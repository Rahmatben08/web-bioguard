<?php

namespace App\Http\Controllers;

use App\Models\PerjalananRute;
use App\Models\LogTelemetri;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    /**
     * Menampilkan halaman laporan, efisiensi rute, dan analisis prediktif AI.
     */
    public function index(\Illuminate\Http\Request $request): View
    {
        $date = $request->input('date');
        $id_box = $request->input('id_box');

        $query = PerjalananRute::with(['kurir', 'logTelemetri' => function($q) use ($date) {
            if ($date) {
                $q->whereDate('timestamp', $date);
            }
        }, 'latestLog.prediksiAi']);

        if ($id_box) {
            $query->where('id_box', $id_box);
        }

        if ($date) {
            $query->whereHas('logTelemetri', function($q) use ($date) {
                $q->whereDate('timestamp', $date);
            });
        }

        $perjalanan = $query->orderBy('id_rute', 'desc')->get();

        $routesData = $perjalanan->map(function ($r) {
            $logs = $r->logTelemetri;
            $totalLogs = $logs->count();
            
            // Hitung rata-rata suhu
            $avgTemp = $totalLogs > 0 ? $logs->avg('suhu_aktual') : 5.0;
            
            // Hitung log yang berada di luar batas (excursions)
            $excursionCount = $logs->filter(function($log) {
                $t = (float) $log->suhu_aktual;
                return $t < 2.0 || $t > 8.0;
            })->count();
            
            $latestLog = $r->latestLog;
            $aiRisk = ($latestLog && $latestLog->prediksiAi && !is_null($latestLog->prediksiAi->probabilitas_rusak)) 
                ? (float) $latestLog->prediksiAi->probabilitas_rusak 
                : null;
            
            // Indeks Efisiensi: 100 - (rasio ekskursi * 0,5) - (risiko AI * 0,4)
            $excursionRate = $totalLogs > 0 ? ($excursionCount / $totalLogs) * 100 : 0;
            $efficiencyIndex = max(15, min(100, 100 - ($excursionRate * 0.6) - ($aiRisk * 0.35)));

            return [
                'id_box' => $r->id_box,
                'nama_kargo' => $r->nama_kargo ?? 'Vaksin Pentabio',
                'tujuan' => $r->lokasi_tujuan,
                'nama_kurir' => $r->kurir?->nama_lengkap ?? 'Tanpa Kurir',
                'avg_temp' => $avgTemp,
                'mkt' => ($latestLog && $latestLog->nilai_mkt) ? (float) $latestLog->nilai_mkt : $avgTemp,
                'excursion_logs' => $excursionCount,
                'ai_risk' => is_null($aiRisk) ? null : $aiRisk,
                'efficiency_index' => is_null($aiRisk) ? $efficiencyIndex : $efficiencyIndex, // If aiRisk is null, we could use a fallback efficiency formula or just use 0 for ai_risk in efficiency formula.

                'status_perjalanan' => $r->status_perjalanan
            ];
        });

        $recentRoutes = PerjalananRute::with(['logTelemetri', 'latestLog.prediksiAi'])
            ->orderBy('id_rute', 'desc')
            ->take(6)
            ->get()
            ->reverse();

        $chartCategories = [];
        $aiRisks = [];
        $actualDamaged = [];

        foreach ($recentRoutes as $r) {
            $chartCategories[] = 'BOX-' . $r->id_box;
            $latestLog = $r->latestLog;
            $aiRisk = ($latestLog && $latestLog->prediksiAi && !is_null($latestLog->prediksiAi->probabilitas_rusak)) ? (float) $latestLog->prediksiAi->probabilitas_rusak : null;
            $aiRisks[] = is_null($aiRisk) ? 0 : $aiRisk; // For charts, 0 or skip? Usually 0 is fine for chart visual.
            
            $exInfo = $r->getExcursionInfo();
            $actualDamaged[] = $exInfo['status'] === 'Tidak Layak Pakai' ? 100 : ($exInfo['status'] === 'Peringatan' ? 30 : 0);
        }

        return view('dashboard.sensors', compact('routesData', 'chartCategories', 'aiRisks', 'actualDamaged'));
    }

    /**
     * API endpoint untuk polling data sensor & analitik secara real-time.
     */
    public function liveData(): \Illuminate\Http\JsonResponse
    {
        $perjalanan = PerjalananRute::with(['kurir', 'logTelemetri', 'latestLog.prediksiAi'])
            ->orderBy('id_rute', 'desc')
            ->get();

        $routesData = $perjalanan->map(function ($r) {
            $logs = $r->logTelemetri;
            $totalLogs = $logs->count();
            $avgTemp = $totalLogs > 0 ? $logs->avg('suhu_aktual') : 5.0;
            $excursionCount = $logs->filter(fn($log) => (float) $log->suhu_aktual < 2.0 || (float) $log->suhu_aktual > 8.0)->count();
            $latestLog = $r->latestLog;
            $aiRisk = ($latestLog && $latestLog->prediksiAi && !is_null($latestLog->prediksiAi->probabilitas_rusak)) ? (float) $latestLog->prediksiAi->probabilitas_rusak : null;
            $excursionRate = $totalLogs > 0 ? ($excursionCount / $totalLogs) * 100 : 0;
            $efficiencyIndex = max(15, min(100, 100 - ($excursionRate * 0.6) - ((is_null($aiRisk) ? 0 : $aiRisk) * 0.35)));

            return [
                'id_box' => $r->id_box,
                'nama_kargo' => $r->nama_kargo ?? 'Vaksin Pentabio',
                'tujuan' => $r->lokasi_tujuan,
                'nama_kurir' => $r->kurir?->nama_lengkap ?? 'Tanpa Kurir',
                'avg_temp' => round($avgTemp, 1),
                'mkt' => ($latestLog && $latestLog->nilai_mkt) ? (float) $latestLog->nilai_mkt : round($avgTemp, 1),
                'excursion_logs' => $excursionCount,
                'ai_risk' => is_null($aiRisk) ? null : round($aiRisk, 2),
                'efficiency_index' => round($efficiencyIndex, 1),
                'status_perjalanan' => $r->status_perjalanan,
            ];
        });

        $totalAnomalies = $routesData->sum('excursion_logs');
        $avgEfficiency = $routesData->count() > 0 ? round($routesData->avg('efficiency_index'), 1) : 100;

        return response()->json([
            'success' => true,
            'timestamp' => now()->toIso8601String(),
            'kpi' => [
                'integritas' => $avgEfficiency,
                'totalAnomali' => $totalAnomalies,
            ],
            'routes' => $routesData,
        ]);
    }

    /**
     * API endpoint untuk mendapatkan posisi realtime armada kurir aktif.
     */
    public function posisiArmada(): \Illuminate\Http\JsonResponse
    {
        $activeRoutes = PerjalananRute::with(['kurir', 'latestLog'])
            ->whereIn('status_perjalanan', ['Aktif', 'Sedang Berjalan'])
            ->get();

        $armadaData = $activeRoutes->map(function ($route) {
            $latestLog = $route->latestLog;
            
            return [
                'id_rute' => $route->id_rute,
                'id_box' => $route->id_box,
                'nama_kurir' => $route->kurir?->nama_lengkap ?? 'Unknown',
                'nomor_kendaraan' => $route->kurir?->nomor_kendaraan ?? 'Unknown',
                'tujuan' => $route->lokasi_tujuan,
                'suhu_aktual' => $latestLog ? (float) $latestLog->suhu_aktual : null,
                'lat' => $latestLog ? (float) $latestLog->latitude : 0.0,
                'lng' => $latestLog ? (float) $latestLog->longitude : 0.0,
                'terakhir_update' => ($latestLog && $latestLog->timestamp) ? $latestLog->timestamp->toIso8601String() : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $armadaData
        ]);
    }
}
