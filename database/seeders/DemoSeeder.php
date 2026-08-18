<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kurir;
use App\Models\PerjalananRute;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::create([
            'name' => 'Admin Bio-Guard',
            'email' => 'admin@bioguard.id',
            'password' => Hash::make('password'),
            'dispatcher_id' => 'PLB-DSC-001',
            'iot_api_key' => 'bg_api_' . Str::random(32),
            'photo' => 'uploads/default-avatar.png',
        ]);

        // 2. Data Kurir Aktual (Untuk Uji ESP32 Fisik)
        \ = Kurir::create([
            'nama_lengkap' => 'Kurir ESP32',
            'nomor_kendaraan' => 'BG 1111 ESP',
            'no_wa' => '+6280000000000'
        ]);

        // Akun Login Kurir
        User::create([
            'name' => 'Kurir ESP32',
            'email' => 'kurir@bioguard.id',
            'password' => Hash::make('password'),
            'id_kurir' => \->id_kurir,
        ]);

        // 3. Rute Perjalanan Aktual (Untuk integrasi dengan BOX-1 fisik)
        PerjalananRute::create([
            'id_kurir' => \->id_kurir,
            'id_box' => 'BOX-1',
            'nama_kargo' => 'Vaksin (Real Test)',
            'lokasi_tujuan' => 'Titik Pengujian',
            'status_perjalanan' => 'aktif',
            'suhu_minimal' => 2.0,
            'suhu_maksimal' => 8.0,
            'waktu_mulai' => Carbon::now(),
            'estimasi_waktu_tiba' => Carbon::now()->addHours(2),
            'origin_lat' => -2.9880,
            'origin_lng' => 104.7560,
            'destination_lat' => -2.9803,
            'destination_lng' => 104.7547,
            'mkt_threshold' => 8.0,
            'jarak_total_km' => 15.5
        ]);
    }
}
