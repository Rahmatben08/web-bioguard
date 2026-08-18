<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kurir;
use App\Models\PerjalananRute;
use App\Models\LogTelemetri;
use App\Models\PrediksiAi;
use App\Models\ThermolabileDrug;
use App\Models\IncidentLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Create default Admin User
        User::create([
            'name' => 'Admin Bio-Guard',
            'email' => 'admin@bioguard.id',
            'password' => Hash::make('password'),
            'dispatcher_id' => 'PLB-DSC-001',
            'iot_api_key' => 'bg_api_' . Str::random(32),
            'photo' => 'uploads/default-avatar.png',
        ]);

        // 1. Create Kurir
        $kurir1 = Kurir::create(['nama_lengkap' => 'Ahmad Fadillah', 'nomor_kendaraan' => 'BG 1234 XYZ', 'no_wa' => '+6281234567891']);
        $kurir2 = Kurir::create(['nama_lengkap' => 'Budi Santoso', 'nomor_kendaraan' => 'BG 5678 ABC', 'no_wa' => '+6281234567892']);
        $kurir3 = Kurir::create(['nama_lengkap' => 'Citra Dewi', 'nomor_kendaraan' => 'BG 9012 DEF', 'no_wa' => '+6281234567893']);
        $kurir4 = Kurir::create(['nama_lengkap' => 'Dedi Kurniawan', 'nomor_kendaraan' => 'BG 3456 GHI', 'no_wa' => '+6281234567894']);
        $kurir5 = Kurir::create(['nama_lengkap' => 'Kurir ESP32 Asli', 'nomor_kendaraan' => 'BG 9999 ESP', 'no_wa' => '+6280000000000']);

        // Akun Login untuk Kurir ESP32
        User::create([
            'name' => 'Kurir ESP32 Asli',
            'email' => 'kurir@bioguard.id',
            'password' => Hash::make('password'),
            'id_kurir' => $kurir5->id_kurir,
        ]);

        // 2. Create Perjalanan Rute
        $rute5 = PerjalananRute::create([
            'id_kurir' => $kurir5->id_kurir,
            'id_box' => 'BOX-1', // HARDWARE ESP32
            'nama_kargo' => 'Vaksin Uji Fisik',
            'lokasi_tujuan' => 'Titik Pengujian Hardware',
            'status_perjalanan' => 'aktif',
        ]);

        $rute1 = PerjalananRute::create([
            'id_kurir' => $kurir1->id_kurir,
            'id_box' => 'BOX-001',
            'nama_kargo' => 'Vaksin Sinovac',
            'lokasi_tujuan' => 'RSUP Dr. Mohammad Hoesin',
            'status_perjalanan' => 'aktif',
        ]);
        $rute2 = PerjalananRute::create([
            'id_kurir' => $kurir2->id_kurir,
            'id_box' => 'BOX-002',
            'nama_kargo' => 'PRC Blood',
            'lokasi_tujuan' => 'RSUD Palembang BARI',
            'status_perjalanan' => 'aktif',
        ]);
        $rute3 = PerjalananRute::create([
            'id_kurir' => $kurir3->id_kurir,
            'id_box' => 'BOX-003',
            'nama_kargo' => 'Insulin Humalog',
            'lokasi_tujuan' => 'RS Charitas',
            'status_perjalanan' => 'aktif',
        ]);
        $rute4 = PerjalananRute::create([
            'id_kurir' => $kurir4->id_kurir,
            'id_box' => 'BOX-004',
            'nama_kargo' => 'Serum Albumin',
            'lokasi_tujuan' => 'Puskesmas Alang-Alang Lebar',
            'status_perjalanan' => 'aktif',
        ]);

        $now = Carbon::now();

        // -------------------------------------------------------------
        // Rute 1 (Aman - Normal Temperature)
        // -------------------------------------------------------------
        $rute1Points = [
            [-2.9880, 104.7560], // Dinas Kesehatan
            [-2.9887, 104.7565], // Masjid Agung
            [-2.9868, 104.7561], // IP
            [-2.9829, 104.7552], // Cinde
            [-2.9803, 104.7547]  // Marathon
        ];
        foreach (range(1, 5) as $i) {
            $log = LogTelemetri::create([
                'id_rute' => $rute1->id_rute,
                'timestamp' => $now->copy()->subMinutes(30 - ($i * 5)),
                'suhu_aktual' => 4.2 + ($i * 0.1), // 4.3 -> 4.7
                'nilai_mkt' => 4.5,
                'latitude' => $rute1Points[$i - 1][0],
                'longitude' => $rute1Points[$i - 1][1],
                'is_synced_from_offline' => false,
                'gaya_guncangan' => 0.05 + ($i * 0.01),
            ]);

            PrediksiAi::create([
                'id_log' => $log->id_log,
                'probabilitas_rusak' => 0.5 + ($i * 0.1),
                'instruksi_mitigasi' => 'Suhu optimal. Pertahankan kondisi saat ini.',
            ]);
        }

        // -------------------------------------------------------------
        // Rute 2 (Peringatan Dini - Anomaly <= 30 seconds)
        // -------------------------------------------------------------
        // Log 1-4 are safe. Log 5 is out of bounds (8.2°C) created 20 seconds ago.
        $rute2Points = [
            [-2.9880, 104.7560], // Dinas Kesehatan
            [-2.9887, 104.7565], // Masjid Agung
            [-2.9912, 104.7592], // Jembatan Ampera (North)
            [-2.9935, 104.7618], // Jembatan Ampera (Center)
            [-2.9961, 104.7628]  // Jembatan Ampera (South)
        ];
        foreach (range(1, 4) as $i) {
            $log = LogTelemetri::create([
                'id_rute' => $rute2->id_rute,
                'timestamp' => $now->copy()->subMinutes(10 - $i),
                'suhu_aktual' => 5.2 + ($i * 0.2), // 5.4 -> 6.0
                'nilai_mkt' => 5.3,
                'latitude' => $rute2Points[$i - 1][0],
                'longitude' => $rute2Points[$i - 1][1],
                'is_synced_from_offline' => false,
                'gaya_guncangan' => 0.06 + ($i * 0.02),
            ]);

            PrediksiAi::create([
                'id_log' => $log->id_log,
                'probabilitas_rusak' => 1.2 + ($i * 0.2),
                'instruksi_mitigasi' => 'Suhu optimal. Pertahankan kondisi saat ini.',
            ]);
        }

        // Last log (out of bounds) 20s ago
        $log2_last = LogTelemetri::create([
            'id_rute' => $rute2->id_rute,
            'timestamp' => $now->copy()->subSeconds(20),
            'suhu_aktual' => 8.2, // Anomaly!
            'nilai_mkt' => 5.8,
            'latitude' => $rute2Points[4][0],
            'longitude' => $rute2Points[4][1],
            'is_synced_from_offline' => false,
            'gaya_guncangan' => 0.12,
        ]);

        PrediksiAi::create([
            'id_log' => $log2_last->id_log,
            'probabilitas_rusak' => 12.50,
            'instruksi_mitigasi' => 'Peringatan dini: Periksa insulasi wadah obat termolabil.',
        ]);


        // -------------------------------------------------------------
        // Rute 3 (Tidak Layak Pakai - Anomaly > 30 seconds, e.g., 120s)
        // -------------------------------------------------------------
        // Log 1-3 safe. Log 4 out of bounds (8.3°C) created 120 seconds ago. Log 5 (8.8°C) created 10 seconds ago.
        $rute3Points = [
            [-2.9880, 104.7560], // Dinas Kesehatan
            [-2.9887, 104.7565], // Masjid Agung
            [-2.9868, 104.7561], // IP
            [-2.9829, 104.7552], // Cinde
            [-2.9803, 104.7547]  // Marathon
        ];
        foreach (range(1, 3) as $i) {
            $log = LogTelemetri::create([
                'id_rute' => $rute3->id_rute,
                'timestamp' => $now->copy()->subMinutes(15 - $i),
                'suhu_aktual' => 6.5 + ($i * 0.3), // 6.8 -> 7.4
                'nilai_mkt' => 7.0,
                'latitude' => $rute3Points[$i - 1][0],
                'longitude' => $rute3Points[$i - 1][1],
                'is_synced_from_offline' => false,
                'gaya_guncangan' => 0.08 + ($i * 0.03),
            ]);

            PrediksiAi::create([
                'id_log' => $log->id_log,
                'probabilitas_rusak' => 4.5 + ($i * 0.5),
                'instruksi_mitigasi' => 'Suhu optimal. Pertahankan kondisi saat ini.',
            ]);
        }

        // Out of bounds log 4 (120s ago)
        $log3_out1 = LogTelemetri::create([
            'id_rute' => $rute3->id_rute,
            'timestamp' => $now->copy()->subSeconds(120),
            'suhu_aktual' => 8.3, // Exceeded 8°C!
            'nilai_mkt' => 7.8,
            'latitude' => $rute3Points[3][0],
            'longitude' => $rute3Points[3][1],
            'is_synced_from_offline' => false,
            'gaya_guncangan' => 1.85, // Shock spike!
        ]);

        PrediksiAi::create([
            'id_log' => $log3_out1->id_log,
            'probabilitas_rusak' => 48.20,
            'instruksi_mitigasi' => 'Peringatan: Obat Termolabil mendekati batas atas kelayakan.',
        ]);

        // Out of bounds log 5 (10s ago)
        $log3_out2 = LogTelemetri::create([
            'id_rute' => $rute3->id_rute,
            'timestamp' => $now->copy()->subSeconds(10),
            'suhu_aktual' => 8.8, // Continuing anomaly!
            'nilai_mkt' => 8.2,
            'latitude' => $rute3Points[4][0],
            'longitude' => $rute3Points[4][1],
            'is_synced_from_offline' => false,
            'gaya_guncangan' => 0.15,
        ]);

        PrediksiAi::create([
            'id_log' => $log3_out2->id_log,
            'probabilitas_rusak' => 91.50, // Spoiled prediction!
            'instruksi_mitigasi' => 'BAHAYA: Obat Termolabil tidak layak pakai. Tarik dari peredaran.',
        ]);


        // -------------------------------------------------------------
        // Rute 4 (Selesai - Completed, normal)
        // -------------------------------------------------------------
        $rute4Points = [
            [-2.9880, 104.7560], // Dinas Kesehatan Palembang
            [-2.9887, 104.7565], // Air Mancur
            [-2.9868, 104.7561]  // IP
        ];
        foreach (range(1, 3) as $i) {
            $log = LogTelemetri::create([
                'id_rute' => $rute4->id_rute,
                'timestamp' => $now->copy()->subHours(2)->subMinutes($i * 10),
                'suhu_aktual' => 3.5 + ($i * 0.2),
                'nilai_mkt' => 3.8,
                'latitude' => $rute4Points[$i - 1][0],
                'longitude' => $rute4Points[$i - 1][1],
                'is_synced_from_offline' => true,
                'gaya_guncangan' => 0.04 + ($i * 0.01),
            ]);

            PrediksiAi::create([
                'id_log' => $log->id_log,
                'probabilitas_rusak' => 0.2 + ($i * 0.1),
                'instruksi_mitigasi' => 'Suhu optimal. Pertahankan kondisi saat ini.',
            ]);
        }

        // 3. Create Thermolabile Drugs (Inventory)
        ThermolabileDrug::create([
            'no_batch' => 'BTCH-SV01',
            'nama_produk' => 'Vaksin Sinovac',
            'jenis' => 'Vaksin',
            'stok' => 24500,
            'suhu_penyimpanan' => 4.0,
            'tanggal_kadaluwarsa' => '2026-10-15',
            'status' => 'Aman'
        ]);

        ThermolabileDrug::create([
            'no_batch' => 'BTCH-PF06',
            'nama_produk' => 'Vaksin Pfizer (Ultra-Cold)',
            'jenis' => 'Vaksin',
            'stok' => 8900,
            'suhu_penyimpanan' => -70.0, // Ultra-cold
            'tanggal_kadaluwarsa' => '2026-11-20',
            'status' => 'Aman'
        ]);

        ThermolabileDrug::create([
            'no_batch' => 'BTCH-PV07',
            'nama_produk' => 'Vaksin Polio (Frozen)',
            'jenis' => 'Vaksin',
            'stok' => 14300,
            'suhu_penyimpanan' => -20.0, // Frozen
            'tanggal_kadaluwarsa' => '2026-12-05',
            'status' => 'Aman'
        ]);

        ThermolabileDrug::create([
            'no_batch' => 'BTCH-IH02',
            'nama_produk' => 'Insulin Humalog',
            'jenis' => 'Insulin',
            'stok' => 12000,
            'suhu_penyimpanan' => 5.0,
            'tanggal_kadaluwarsa' => '2026-06-03',
            'status' => 'Aman'
        ]);

        ThermolabileDrug::create([
            'no_batch' => 'BTCH-SA03',
            'nama_produk' => 'Serum Albumin',
            'jenis' => 'Serum Darah',
            'stok' => 3500,
            'suhu_penyimpanan' => 6.0,
            'tanggal_kadaluwarsa' => '2026-09-20',
            'status' => 'Aman'
        ]);

        ThermolabileDrug::create([
            'no_batch' => 'BTCH-BF04',
            'nama_produk' => 'Vaksin Bio Farma Flu',
            'jenis' => 'Vaksin',
            'stok' => 1800,
            'suhu_penyimpanan' => 2.5,
            'tanggal_kadaluwarsa' => '2026-05-30',
            'status' => 'Peringatan Dini'
        ]);

        ThermolabileDrug::create([
            'no_batch' => 'BTCH-AT05',
            'nama_produk' => 'Serum Anti-Tetanus',
            'jenis' => 'Serum Darah',
            'stok' => 3240,
            'suhu_penyimpanan' => 4.5,
            'tanggal_kadaluwarsa' => '2026-05-29',
            'status' => 'Karantina'
        ]);

        // 4. Create Incident Logs
        IncidentLog::create([
            'id_rute' => $rute3->id_rute,
            'jenis_insiden' => 'Tidak Layak Pakai',
            'deskripsi' => 'Suhu melebihi batas atas (> 8°C) selama lebih dari 30 detik pada Box BOX-003.',
            'suhu_tercatat' => 8.8,
            'durasi_anomali' => 120,
            'status' => 'aktif'
        ]);

        IncidentLog::create([
            'id_rute' => $rute2->id_rute,
            'jenis_insiden' => 'Peringatan Dini',
            'deskripsi' => 'Suhu berfluktuasi mendekati batas atas (8.2°C) selama 20 detik pada Box BOX-002.',
            'suhu_tercatat' => 8.2,
            'durasi_anomali' => 20,
            'status' => 'aktif'
        ]);

        IncidentLog::create([
            'id_rute' => $rute4->id_rute,
            'jenis_insiden' => 'Peringatan Dini',
            'deskripsi' => 'Suhu drop di bawah 2°C pada Box BOX-004.',
            'suhu_tercatat' => 1.8,
            'durasi_anomali' => 15,
            'status' => 'resolved'
        ]);
    }
}
