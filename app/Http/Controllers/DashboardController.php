<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\PerjalananRute;
use App\Models\LogTelemetri;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TelemetryExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * DashboardController - Menampilkan dashboard monitoring faskes.
 */
class DashboardController extends Controller
{
    /**
     * Halaman utama dashboard monitoring.
     * Menampilkan peta live tracking dan tabel data kurir aktif.
     */
    public function index(\Illuminate\Http\Request $request): View
    {
        $date = $request->input('date');

        $query = PerjalananRute::with(['kurir', 'latestLog' => function($q) use ($date) {
            if ($date) {
                $q->whereDate('timestamp', $date);
            }
        }, 'latestLog.prediksiAi']);

        if ($date) {
            $query->whereHas('logTelemetri', function($q) use ($date) {
                $q->whereDate('timestamp', $date);
            });
        } else {
            $query->aktif();
        }

        $perjalananAktif = $query->get();

        // Hitung statistik
        $totalKurirAktif = $perjalananAktif->count();
        
        $pendingQuery = LogTelemetri::where('is_synced_from_offline', true);
        if ($date) {
            $pendingQuery->whereDate('timestamp', $date);
        }
        $totalPendingSync = $pendingQuery->count();
        
        // Alert count adalah perjalanan yang statusnya bukan 'Aman' (peringatan dini atau tidak layak pakai)
        $alertCount = $perjalananAktif->filter(function ($p) {
            $info = $p->getExcursionInfo();
            return $info['status'] !== 'Aman';
        })->count();

        return view('dashboard.monitoring', compact(
            'perjalananAktif',
            'totalKurirAktif',
            'totalPendingSync',
            'alertCount'
        ));
    }

    /**
     * API endpoint untuk data marker peta (digunakan oleh JavaScript fetch).
     * Mengembalikan JSON dengan data lokasi kurir aktif untuk Leaflet.js.
     */
    public function mapData(\Illuminate\Http\Request $request): JsonResponse
    {
        return $this->liveData($request);
    }

    /**
     * API GET /api/dashboard/live-data - dipanggil setiap 3 atau 5 detik.
     * Mengembalikan data rute aktif, koordinat kurir, asal/tujuan, serta telemetri & AI.
     */
    public function liveData(\Illuminate\Http\Request $request): JsonResponse
    {
        $date = $request->input('date');
        
        // Koordinat tujuan & asal default (Palembang)
        $coordinatesLookup = [
            'RSUP Dr. Mohammad Hoesin' => ['lat' => -2.9662628, 'lng' => 104.7498217],
            'RSUD Palembang BARI' => ['lat' => -3.0185, 'lng' => 104.7645],
            'RS Charitas' => ['lat' => -2.9772, 'lng' => 104.7522],
            'RS RK Charitas' => ['lat' => -2.9759693, 'lng' => 104.7528599],
            'Puskesmas Dempo' => ['lat' => -2.9818201, 'lng' => 104.7589042],
            'RSUD Siti Fatimah' => ['lat' => -2.9482931, 'lng' => 104.7345504],
            'RS Hermina' => ['lat' => -2.9559237, 'lng' => 104.74846],
            'RS Siloam Sriwijaya' => ['lat' => -2.9776129, 'lng' => 104.7422702],
            'RS Bhayangkara' => ['lat' => -2.9587303, 'lng' => 104.7374268],
            'RS Muhammadiyah' => ['lat' => -3.0003649, 'lng' => 104.8163221],
            'RS Myria' => ['lat' => -2.9398741, 'lng' => 104.7269887],
            'RS Ernaldi Bahar' => ['lat' => -2.922228, 'lng' => 104.6846093],
            'RS Pelabuhan' => ['lat' => -2.978579, 'lng' => 104.7766276],
            'Puskesmas Merdeka' => ['lat' => -2.9904511, 'lng' => 104.7528331],
            'Puskesmas Plaju' => ['lat' => -2.9957835, 'lng' => 104.8136447],
            'Puskesmas 7 Ulu' => ['lat' => -2.9967184, 'lng' => 104.7639636],
            'Puskesmas 11 Ilir' => ['lat' => -2.9811521, 'lng' => 104.7673696],
            'Puskesmas Kalidoni' => ['lat' => -2.9404873, 'lng' => 104.7674479],
            'Puskesmas Kenten' => ['lat' => -2.9404873, 'lng' => 104.7674479],
            'Puskesmas Boom Baru' => ['lat' => -2.9754512, 'lng' => 104.7824651],
            'Puskesmas Kampus' => ['lat' => -2.9754956, 'lng' => 104.7382453],
            'Puskesmas Alang-Alang Lebar' => ['lat' => -2.9394118, 'lng' => 104.7000131],
            'Dinas Kesehatan Kota Palembang' => ['lat' => -2.9901778, 'lng' => 104.7573614],
        ];
        
        $originCoordinates = ['lat' => -2.9880, 'lng' => 104.7560]; // Dinas Kesehatan Palembang

        $query = PerjalananRute::with(['kurir', 'latestLog' => function($q) use ($date) {
            if ($date) {
                $q->whereDate('timestamp', $date);
            }
        }, 'latestLog.prediksiAi']);

        if ($date) {
            $query->whereHas('logTelemetri', function($q) use ($date) {
                $q->whereDate('timestamp', $date);
            });
        } else {
            $query->aktif();
        }

        $perjalananList = $query->get();

        $totalKurirAktif = $perjalananList->count();
        
        $pendingQuery = LogTelemetri::where('is_synced_from_offline', true);
        if ($date) {
            $pendingQuery->whereDate('timestamp', $date);
        }
        $totalPendingSync = $pendingQuery->count();

        $mappedData = $perjalananList->map(function ($perjalanan) use ($coordinatesLookup, $originCoordinates) {
                $log = $perjalanan->latestLog;
                $excursion = $perjalanan->getExcursionInfo();
                $prediksi = $log ? $log->prediksiAi : null;
                $probabilitas = $prediksi ? (float) $prediksi->probabilitas_rusak : 0.0;
                $destCoord = $coordinatesLookup[$perjalanan->lokasi_tujuan] ?? ['lat' => -2.9900, 'lng' => 104.7500];
                $health = $perjalanan->getDeviceHealth();
                $battery = $health['battery'];
                $signal = $health['signal'];
                if ($perjalanan->id_box !== 'BOX-003') {
                    $battery = min(100, $battery + (time() % 3) - 1);
                    $signal = min(-50, $signal + (time() % 5) - 2);
                } else {
                    $battery = 11 + (time() % 3);
                    $signal = -100 - (time() % 4);
                }

                $isRerouted = \App\Models\IncidentLog::where('id_rute', $perjalanan->id_rute)
                    ->where('jenis_insiden', 'Peringatan Dini')
                    ->where('status', 'resolved')
                    ->exists();

                return [
                    'id_rute' => $perjalanan->id_rute,
                    'nama_kurir' => $perjalanan->kurir->nama_lengkap,
                    'nomor_kendaraan' => $perjalanan->kurir->nomor_kendaraan,
                    'no_wa' => $perjalanan->kurir->no_wa,
                    'nama_kargo' => $perjalanan->nama_kargo,
                    'lokasi_tujuan' => $perjalanan->lokasi_tujuan,
                    'id_box' => $perjalanan->id_box,
                    
                    // Kesehatan Perangkat
                    'battery_level' => $battery,
                    'signal_strength' => $signal,
                    'calibration_status' => $health['calibration'],
                    
                    // Koordinat kurir aktual
                    'latitude' => $log ? $log->latitude : -2.9880,
                    'longitude' => $log ? $log->longitude : 104.7560,
                    
                    // Koordinat asal & tujuan untuk polyline rute
                    'origin_latitude' => $originCoordinates['lat'],
                    'origin_longitude' => $originCoordinates['lng'],
                    'dest_latitude' => $destCoord['lat'],
                    'dest_longitude' => $destCoord['lng'],
                    
                    'suhu_aktual' => $log ? (float) $log->suhu_aktual : 5.0,
                    'nilai_mkt' => ($log && $log->nilai_mkt) ? (float) $log->nilai_mkt : null,
                    'gaya_guncangan' => ($log && $log->gaya_guncangan) ? (float) $log->gaya_guncangan : 0.05,
                    'timestamp' => $log ? $log->timestamp->toIso8601String() : now()->toIso8601String(),
                    'excursion_duration' => $excursion['duration'],
                    'excursion_status' => $excursion['status'],
                    'status_label' => $excursion['status_label'],
                    'badge_class' => $excursion['badge_class'],
                    'text_class' => $excursion['text_class'],
                    'border_class' => $excursion['border_class'],
                    'probabilitas_rusak' => $probabilitas,
                    'is_safe' => $excursion['status'] === 'Aman' || $excursion['status'] === 'Peringatan',
                    'is_rerouted' => $isRerouted,
                ];
            })
            ->values();

        $alertCount = $mappedData->filter(fn ($p) => $p['excursion_status'] !== 'Aman')->count();


        return response()->json([
            'success' => true,
            'stats' => [
                'total_kurir_aktif' => $totalKurirAktif,
                'total_pending_sync' => $totalPendingSync,
                'alert_count' => $alertCount,
            ],
            'data' => $mappedData,
        ]);
    }

    /**
     * Generate QR Code untuk boks fisik berdasarkan id_box.
     */
    public function generateBoxQr(string $id_box): View
    {
        // Generate QR code dengan data id_box
        $qrCode = QrCode::size(300)
            ->color(0, 0, 0) // Black
            ->backgroundColor(255, 255, 255) // White Background
            ->margin(2)
            ->generate($id_box);

        return view('dashboard.qr_print', compact('qrCode', 'id_box'));
    }

    /**
     * Generate QR Code untuk batch obat.
     */
    public function generateBatchQr(string $batch_id): View
    {
        // Generate QR code dengan data batch_id
        $qrCode = QrCode::size(300)
            ->color(0, 0, 0) // Black
            ->backgroundColor(255, 255, 255) // White Background
            ->margin(2)
            ->generate($batch_id);

        return view('dashboard.batch_qr_print', compact('qrCode', 'batch_id'));
    }

    /**
     * Ekspor data tabel telemetri lengkap ke file Laporan_Audit_Suhu.xlsx.
     */
    public function exportTelemetry(\Illuminate\Http\Request $request): BinaryFileResponse
    {
        $date = $request->input('date');
        $id_box = $request->input('id_box');
        return Excel::download(new TelemetryExport($date, $id_box), 'Laporan_Audit_Suhu.xlsx');
    }

    /**
     * Alias method untuk kecocokan penamaan ekspor.
     */
    public function exportTelemetryToExcel(\Illuminate\Http\Request $request): BinaryFileResponse
    {
        return $this->exportTelemetry($request);
    }

    /**
     * Menampilkan halaman cetak jejak audit digital CDOB.
     */
    public function printAuditTrail(): View
    {
        $perjalananList = PerjalananRute::with(['kurir', 'latestLog', 'logTelemetri'])->get();
        return view('dashboard.audit_pdf', compact('perjalananList'));
    }

    /**
     * Mengubah status rute perjalanan menjadi selesai saat tiba di Geofence faskes tujuan.
     */
    public function completeRoute(string $id): JsonResponse
    {
        $rute = PerjalananRute::find($id);
        if (!$rute) {
            return response()->json([
                'success' => false,
                'message' => 'Rute perjalanan tidak ditemukan.'
            ], 404);
        }

        $rute->update([
            'status_perjalanan' => 'selesai'
        ]);

        // Create IncidentLog indicating automatic geofencing check-in
        \App\Models\IncidentLog::create([
            'id_rute' => $rute->id_rute,
            'jenis_insiden' => 'Tiba di Lokasi',
            'deskripsi' => "Kargo Boks {$rute->id_box} berhasil tiba di {$rute->lokasi_tujuan}. Geofencing terverifikasi otomatis, data log dikunci.",
            'suhu_tercatat' => $rute->latestLog ? $rute->latestLog->suhu_aktual : 4.5,
            'durasi_anomali' => 0,
            'status' => 'resolved'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rute perjalanan berhasil diselesaikan via Geofencing Otomatis.',
            'data' => $rute
        ]);
    }

    /**
     * API endpoint untuk widget publik di landing page.
     * Mengembalikan data agregat dan anonim (rata-rata, min, max suhu)
     * dari perjalanan rute yang sedang aktif.
     */
    public function publicStats(): JsonResponse
    {
        $data = \Illuminate\Support\Facades\Cache::remember('public_stats_ringkas', 10, function () {
            $activeRoutes = PerjalananRute::with('latestLog')->aktif()->get();
            
            $hasActiveData = false;
            $avgTemp = null;
            $minTemp = null;
            $maxTemp = null;

            if ($activeRoutes->isNotEmpty()) {
                $latestLogs = $activeRoutes->map(fn($r) => $r->latestLog)->filter();
                if ($latestLogs->isNotEmpty()) {
                    $hasActiveData = true;
                    $avgTemp = $latestLogs->avg('suhu_aktual');
                    $minTemp = $latestLogs->min('suhu_aktual');
                    $maxTemp = $latestLogs->max('suhu_aktual');
                }
            }

            return [
                'success' => true,
                'data' => [
                    'has_active_data' => $hasActiveData,
                    'avg_temp' => $hasActiveData ? round((float)$avgTemp, 1) : null,
                    'min_temp' => $hasActiveData ? round((float)$minTemp, 1) : null,
                    'max_temp' => $hasActiveData ? round((float)$maxTemp, 1) : null,
                ]
            ];
        });

        return response()->json($data);
    }
}
