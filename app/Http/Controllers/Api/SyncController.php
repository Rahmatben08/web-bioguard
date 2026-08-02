<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SyncTelemetriRequest;
use App\Models\LogTelemetri;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * SyncController - Menerima data telemetri massal dari aplikasi Flutter.
 */
class SyncController extends Controller
{
    /**
     * Upsert massal data telemetri dan prediksi AI.
     */
    public function upsertTelemetri(SyncTelemetriRequest $request): JsonResponse
    {
        if (!auth()->user()->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.'
            ], 403);
        }

        $validated = $request->validated();
        $records = $validated['data'];

        try {
            DB::beginTransaction();

            // Prepare records for upsert
            $upsertData = collect($records)->map(function ($record) {
                return [
                    'id_rute' => $record['id_rute'],
                    'timestamp' => $record['timestamp'],
                    'suhu_aktual' => $record['suhu_aktual'],
                    'nilai_mkt' => $record['nilai_mkt'] ?? null,
                    'latitude' => $record['latitude'],
                    'longitude' => $record['longitude'],
                    'is_synced_from_offline' => $record['is_synced_from_offline'] ?? true,
                    'gaya_guncangan' => $record['gaya_guncangan'] ?? 0.05,
                ];
            })->toArray();

            // Mass upsert: insert or update based on id_rute + timestamp combination
            $upserted = LogTelemetri::upsert(
                $upsertData,
                ['id_rute', 'timestamp'], // Unique columns for matching
                ['suhu_aktual', 'nilai_mkt', 'latitude', 'longitude', 'is_synced_from_offline', 'gaya_guncangan'] // Columns to update
            );

            // Fetch the updated/inserted logs to generate corresponding AI predictions
            $syncedLogs = LogTelemetri::with('perjalananRute')
                ->whereIn('id_rute', collect($records)->pluck('id_rute'))
                ->whereIn('timestamp', collect($records)->pluck('timestamp'))
                ->get();

                $prediksiData = [];
            $predictionService = new \App\Services\PredictionService();

            foreach ($syncedLogs as $log) {
                $suhu = (float) $log->suhu_aktual;
                $rute = $log->perjalananRute;
                
                // Heuristic Fallback values
                $prob = 0.0;
                $rekomendasi = 'Suhu optimal. Pertahankan kondisi saat ini.';
                $sisaJarak = 0;

                if ($rute) {
                    $sisaJarak = $predictionService->getEstimatedRemainingDistance($rute->lokasi_tujuan, $log->latitude, $log->longitude);
                }

                $fluktuasiMkt = $log->nilai_mkt ? ((float) $log->nilai_mkt - 8.0) : ($suhu - 8.0);
                
                $aiResult = $predictionService->predictRisk($sisaJarak, 0, $fluktuasiMkt);
                $prob = $aiResult['probabilitas_rusak'];
                $rekomendasi = $aiResult['instruksi_mitigasi'];

                $prediksiData[] = [
                    'id_log' => $log->id_log,
                    'sisa_jarak_km' => $sisaJarak,
                    'probabilitas_rusak' => $prob,
                    'instruksi_mitigasi' => $rekomendasi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Check if this log violates Rule 3 (Temp > 8°C for > 30s or Temp < 2°C) and log it
                if ($rute) {
                    $excursion = $rute->getExcursionInfo();
                    $duration = $excursion['duration'];
                    
                    if ($suhu < 2.0 || ($suhu > 8.0 && $duration > 30)) {
                        $activeIncident = \App\Models\IncidentLog::where('id_rute', $rute->id_rute)
                            ->where('status', 'aktif')
                            ->first();
                        
                        if (!$activeIncident) {
                            $desc = ($suhu < 2.0)
                                ? "Suhu penyimpanan drop di bawah batas aman (2°C) menjadi {$suhu}°C pada Box {$rute->id_box}."
                                : "Suhu penyimpanan melebihi batas aman (8°C) menjadi {$suhu}°C selama {$duration} detik pada Box {$rute->id_box}.";
                            
                            \App\Models\IncidentLog::create([
                                'id_rute' => $rute->id_rute,
                                'jenis_insiden' => ($suhu < 2.0) ? 'Peringatan Dini' : 'Tidak Layak Pakai',
                                'deskripsi' => $desc,
                                'suhu_tercatat' => $suhu,
                                'durasi_anomali' => $duration,
                                'status' => 'aktif',
                            ]);
                        } else {
                            $activeIncident->update([
                                'suhu_tercatat' => max($activeIncident->suhu_tercatat, $suhu),
                                'durasi_anomali' => max($activeIncident->durasi_anomali, $duration),
                            ]);
                        }
                    }
                }
            }

            if (!empty($prediksiData)) {
                \App\Models\PrediksiAi::upsert(
                    $prediksiData,
                    ['id_log'],
                    ['sisa_jarak_km', 'probabilitas_rusak', 'instruksi_mitigasi', 'updated_at']
                );
            }

            DB::commit();

            Log::info('Telemetri sync berhasil', [
                'total_records' => count($records),
                'upserted' => $upserted,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data telemetri berhasil disinkronkan.',
                'synced_count' => count($records),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Telemetri sync gagal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyinkronkan data telemetri.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error.',
            ], 500);
        }
    }
}
