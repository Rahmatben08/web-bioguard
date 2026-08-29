<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SyncTelemetriRequest;
use App\Models\LogTelemetri;
use App\Models\PerjalananRute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * SyncController - Menerima data telemetri massal dari aplikasi Flutter.
 */
class SyncController extends Controller
{
    /**
     * Menghitung jarak antar dua titik kordinat dalam kilometer (Haversine Formula)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
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
            // Prepare records for upsert with outlier detection
            $recordsCollection = collect($records)->sortBy('timestamp')->groupBy('id_rute');
            $upsertData = [];

            foreach ($recordsCollection as $idRute => $routeRecords) {
                // Get the last valid log for this route before these new records
                $lastLog = LogTelemetri::where('id_rute', $idRute)
                    ->where('is_outlier', false)
                    ->orderBy('timestamp', 'desc')
                    ->first();
                
                $lastLat = $lastLog ? (float) $lastLog->latitude : null;
                $lastLng = $lastLog ? (float) $lastLog->longitude : null;
                $lastTime = $lastLog ? \Carbon\Carbon::parse($lastLog->timestamp) : null;

                foreach ($routeRecords as $record) {
                    $isOutlier = false;
                    $currentTime = \Carbon\Carbon::parse($record['timestamp']);
                    
                    $lat = (float) $record['latitude'];
                    $lng = (float) $record['longitude'];

                    if ($lat == 0.0 && $lng == 0.0) {
                        // Abaikan perhitungan untuk koordinat 0,0 (GPS belum fix)
                        $isOutlier = true;
                    } elseif ($lastLat !== null && $lastLng !== null && $lastTime !== null) {
                        $distance = $this->calculateDistance($lastLat, $lastLng, $lat, $lng);
                        $timeDiffHours = $lastTime->diffInSeconds($currentTime) / 3600;
                        
                        if ($timeDiffHours > 0) {
                            $speed = $distance / $timeDiffHours;
                            if ($speed > 80) { // Limit kecepatan wajar kendaraan kota: 80 km/jam
                                $isOutlier = true;
                            }
                        }
                    }
                    
                    // Jika data wajar, update referensi last log ke titik ini
                    if (!$isOutlier) {
                        $lastLat = (float) $record['latitude'];
                        $lastLng = (float) $record['longitude'];
                        $lastTime = $currentTime;
                    }

                    $upsertData[] = [
                        'id_rute' => $record['id_rute'],
                        'timestamp' => \Carbon\Carbon::parse($record['timestamp'])->format('Y-m-d H:i:s'),
                        'suhu_aktual' => $record['suhu_aktual'],
                        'nilai_mkt' => $record['nilai_mkt'] ?? null,
                        'latitude' => $record['latitude'],
                        'longitude' => $record['longitude'],
                        'is_synced_from_offline' => $record['is_synced_from_offline'] ?? true,
                        'gaya_guncangan' => $record['gaya_guncangan'] ?? 0.05,
                        'is_outlier' => $isOutlier,
                    ];
                }
            }

            // Mass upsert: insert or update based on id_rute + timestamp combination
            $upserted = LogTelemetri::upsert(
                $upsertData,
                ['id_rute', 'timestamp'], // Unique columns for matching
                ['suhu_aktual', 'nilai_mkt', 'latitude', 'longitude', 'is_synced_from_offline', 'gaya_guncangan', 'is_outlier'] // Columns to update
            );

            // Fetch the updated/inserted logs to generate corresponding AI predictions
            $timestampsToFetch = collect($upsertData)->pluck('timestamp');
            $syncedLogs = LogTelemetri::with('perjalananRute')
                ->whereIn('id_rute', collect($records)->pluck('id_rute'))
                ->whereIn('timestamp', $timestampsToFetch)
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

                $mkt = $log->nilai_mkt ? (float) $log->nilai_mkt : $suhu;
                
                // Panggil Model ML untuk evaluasi prediktif secara asynchronous (Non-Blocking)
                \App\Jobs\ProcessAiPrediction::dispatch($log->id_log, $sisaJarak, $suhu, $mkt);

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

    /**
     * Menerima data telemetri dari simulator publik (tanpa auth, disimpan di tabel demo_telemetri terpisah)
     */
    public function demoSync(SyncTelemetriRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $records = $validated['data'];

        try {
            DB::beginTransaction();

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

            // Insert data into demo_telemetri using raw model insert/upsert
            \App\Models\DemoTelemetri::upsert(
                $upsertData,
                ['id_rute', 'timestamp'],
                ['suhu_aktual', 'nilai_mkt', 'latitude', 'longitude', 'is_synced_from_offline', 'gaya_guncangan']
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data telemetri demo berhasil disinkronkan.',
                'synced_count' => count($records),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Demo telemetri sync gagal', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyinkronkan data telemetri demo.',
            ], 500);
        }
    }

    /**
     * Validasi Pemasangan Kurir dan Box (Pairing).
     * Mencegah 1 box dipakai 2 kurir dan mengecek kesesuaian rute.
     */
    public function validatePairing(Request $request): JsonResponse
    {
        $request->validate([
            'box_id' => 'required|string'
        ]);

        $boxId = $request->box_id;
        $idKurir = auth()->user()->id_kurir;

        // 1. Cek apakah box ini sedang dipakai kurir lain
        $boxUsedByOther = PerjalananRute::where('id_box', $boxId)
            ->whereIn('status_perjalanan', ['aktif', 'Aktif', 'sedang berjalan', 'Sedang Berjalan'])
            ->where('id_kurir', '!=', $idKurir)
            ->first();

        if ($boxUsedByOther) {
            return response()->json([
                'success' => false,
                'message' => 'Box ini sedang digunakan kurir lain.'
            ], 403);
        }

        // 2. Cek apakah kurir ini punya rute aktif
        $activeRoute = PerjalananRute::where('id_kurir', $idKurir)
            ->whereIn('status_perjalanan', ['aktif', 'Aktif', 'sedang berjalan', 'Sedang Berjalan'])
            ->first();

        if (!$activeRoute) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki rute aktif saat ini. Hubungi admin.'
            ], 403);
        }

        // 3. Cek apakah box_id yang di-scan sama dengan box di rute aktif
        if ($activeRoute->id_box !== $boxId) {
            return response()->json([
                'success' => false,
                'message' => 'Box ini bukan bagian dari rute aktif Anda. Silakan scan box yang sesuai penugasan (' . $activeRoute->id_box . ').'
            ], 403);
        }

        // Jika semua lolos
        return response()->json([
            'success' => true,
            'message' => 'Validasi berhasil. Lanjutkan koneksi.',
            'data' => [
                'rute' => $activeRoute
            ]
        ]);
    }

    /**
     * Endpoint API Konfirmasi Serah Terima Kurir
     * Memanggil Job Antrean untuk mencatat perpindahan ke Stock Ledger.
     */
    public function completeDelivery(Request $request): JsonResponse
    {
        $request->validate([
            'route_id' => 'required|string',
            'faskes_id' => 'required|string'
        ]);

        $routeId = $request->route_id;
        $faskesId = $request->faskes_id;

        // Dispatch job queue
        \App\Jobs\ProcessDeliveryStockJob::dispatch($routeId, $faskesId);

        return response()->json([
            'success' => true,
            'message' => 'Konfirmasi serah terima berhasil diproses. Stok dan buku besar sedang diperbarui.',
        ]);
    }
}
