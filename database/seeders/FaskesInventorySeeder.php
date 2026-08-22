<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryHub;
use Carbon\Carbon;

class FaskesInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the table safely
        DB::table('inventory_hubs')->truncate();

        $faskesList = [
            [
                'id_faskes' => 'RS-001',
                'nama' => 'RSUP Dr. Mohammad Hoesin',
                'kategori' => 'Rumah Sakit',
                'kecamatan' => 'Kemuning',
                'kulkas_farmasi' => 'Modena 500L',
                'kapasitas_terisi' => 85,
                'suhu_aktual' => 4.5,
                'last_sync' => Carbon::now()->subMinutes(2),
                'stok_vaksin' => json_encode(['totalStok' => 8500, 'kapasitas_total' => 10000, 'pfizer' => 3000, 'polio' => 2500, 'sinovac' => 2000, 'insulin' => 1000]),
            ],
            [
                'id_faskes' => 'RS-002',
                'nama' => 'RSUD Palembang BARI',
                'kategori' => 'Rumah Sakit',
                'kecamatan' => 'Seberang Ulu I',
                'kulkas_farmasi' => 'Modena 200L',
                'kapasitas_terisi' => 60,
                'suhu_aktual' => 5.2,
                'last_sync' => Carbon::now()->subMinutes(5),
                'stok_vaksin' => json_encode(['totalStok' => 3000, 'kapasitas_total' => 5000, 'pfizer' => 1000, 'polio' => 1000, 'sinovac' => 500, 'insulin' => 500]),
            ],
            [
                'id_faskes' => 'RS-003',
                'nama' => 'RS Siti Khadijah',
                'kategori' => 'Rumah Sakit',
                'kecamatan' => 'Ilir Barat I',
                'kulkas_farmasi' => 'Gea 300L',
                'kapasitas_terisi' => 70,
                'suhu_aktual' => 3.8,
                'last_sync' => Carbon::now()->subMinutes(1),
                'stok_vaksin' => json_encode(['totalStok' => 3500, 'kapasitas_total' => 5000, 'pfizer' => 1500, 'polio' => 1000, 'sinovac' => 500, 'insulin' => 500]),
            ],
            [
                'id_faskes' => 'RS-004',
                'nama' => 'RS RK Charitas',
                'kategori' => 'Rumah Sakit',
                'kecamatan' => 'Ilir Timur I',
                'kulkas_farmasi' => 'Modena 300L',
                'kapasitas_terisi' => 90,
                'suhu_aktual' => 4.2,
                'last_sync' => Carbon::now()->subMinutes(10),
                'stok_vaksin' => json_encode(['totalStok' => 4500, 'kapasitas_total' => 5000, 'pfizer' => 2000, 'polio' => 1000, 'sinovac' => 1000, 'insulin' => 500]),
            ],
            [
                'id_faskes' => 'RS-005',
                'nama' => 'RS Pelabuhan Palembang',
                'kategori' => 'Rumah Sakit',
                'kecamatan' => 'Boom Baru',
                'kulkas_farmasi' => 'Samsung 200L',
                'kapasitas_terisi' => 50,
                'suhu_aktual' => 5.5,
                'last_sync' => Carbon::now()->subMinutes(15),
                'stok_vaksin' => json_encode(['totalStok' => 2500, 'kapasitas_total' => 5000, 'pfizer' => 500, 'polio' => 1000, 'sinovac' => 500, 'insulin' => 500]),
            ],
            [
                'id_faskes' => 'PKM-001',
                'nama' => 'Puskesmas Merdeka',
                'kategori' => 'Puskesmas',
                'kecamatan' => 'Bukit Kecil',
                'kulkas_farmasi' => 'Gea 100L',
                'kapasitas_terisi' => 80,
                'suhu_aktual' => 6.1,
                'last_sync' => Carbon::now()->subMinutes(3),
                'stok_vaksin' => json_encode(['totalStok' => 1600, 'kapasitas_total' => 2000, 'pfizer' => 500, 'polio' => 500, 'sinovac' => 400, 'insulin' => 200]),
            ],
            [
                'id_faskes' => 'PKM-002',
                'nama' => 'Puskesmas Dempo',
                'kategori' => 'Puskesmas',
                'kecamatan' => 'Ilir Timur I',
                'kulkas_farmasi' => 'Gea 100L',
                'kapasitas_terisi' => 95,
                'suhu_aktual' => 9.2, // Warning status
                'last_sync' => Carbon::now()->subMinutes(1),
                'stok_vaksin' => json_encode(['totalStok' => 1900, 'kapasitas_total' => 2000, 'pfizer' => 800, 'polio' => 500, 'sinovac' => 400, 'insulin' => 200]),
            ],
            [
                'id_faskes' => 'PKM-003',
                'nama' => 'Puskesmas Sukarami',
                'kategori' => 'Puskesmas',
                'kecamatan' => 'Sukarami',
                'kulkas_farmasi' => 'Modena 150L',
                'kapasitas_terisi' => 60,
                'suhu_aktual' => 4.8,
                'last_sync' => Carbon::now()->subMinutes(20),
                'stok_vaksin' => json_encode(['totalStok' => 1800, 'kapasitas_total' => 3000, 'pfizer' => 600, 'polio' => 600, 'sinovac' => 400, 'insulin' => 200]),
            ],
            [
                'id_faskes' => 'PKM-004',
                'nama' => 'Puskesmas 11 Ilir',
                'kategori' => 'Puskesmas',
                'kecamatan' => 'Ilir Timur II',
                'kulkas_farmasi' => 'Gea 100L',
                'kapasitas_terisi' => 40,
                'suhu_aktual' => 5.0,
                'last_sync' => Carbon::now()->subMinutes(5),
                'stok_vaksin' => json_encode(['totalStok' => 800, 'kapasitas_total' => 2000, 'pfizer' => 200, 'polio' => 300, 'sinovac' => 200, 'insulin' => 100]),
            ],
            [
                'id_faskes' => 'PKM-005',
                'nama' => 'Puskesmas Alang-Alang Lebar',
                'kategori' => 'Puskesmas',
                'kecamatan' => 'Alang-Alang Lebar',
                'kulkas_farmasi' => 'Modena 100L',
                'kapasitas_terisi' => 85,
                'suhu_aktual' => 3.5,
                'last_sync' => Carbon::now()->subMinutes(7),
                'stok_vaksin' => json_encode(['totalStok' => 1700, 'kapasitas_total' => 2000, 'pfizer' => 600, 'polio' => 500, 'sinovac' => 400, 'insulin' => 200]),
            ],
            [
                'id_faskes' => 'PKM-006',
                'nama' => 'Puskesmas Pembina',
                'kategori' => 'Puskesmas',
                'kecamatan' => 'Seberang Ulu I',
                'kulkas_farmasi' => 'Gea 100L',
                'kapasitas_terisi' => 70,
                'suhu_aktual' => 1.5, // Danger status
                'last_sync' => Carbon::now()->subMinutes(30),
                'stok_vaksin' => json_encode(['totalStok' => 1400, 'kapasitas_total' => 2000, 'pfizer' => 400, 'polio' => 400, 'sinovac' => 400, 'insulin' => 200]),
            ],
            [
                'id_faskes' => 'PKM-007',
                'nama' => 'Puskesmas Plaju',
                'kategori' => 'Puskesmas',
                'kecamatan' => 'Plaju',
                'kulkas_farmasi' => 'Modena 100L',
                'kapasitas_terisi' => 50,
                'suhu_aktual' => 4.0,
                'last_sync' => Carbon::now()->subMinutes(12),
                'stok_vaksin' => json_encode(['totalStok' => 1000, 'kapasitas_total' => 2000, 'pfizer' => 300, 'polio' => 300, 'sinovac' => 200, 'insulin' => 200]),
            ],
            [
                'id_faskes' => 'PKM-008',
                'nama' => 'Puskesmas Kenten',
                'kategori' => 'Puskesmas',
                'kecamatan' => 'Kalidoni',
                'kulkas_farmasi' => 'Gea 150L',
                'kapasitas_terisi' => 65,
                'suhu_aktual' => 5.8,
                'last_sync' => Carbon::now()->subMinutes(8),
                'stok_vaksin' => json_encode(['totalStok' => 1950, 'kapasitas_total' => 3000, 'pfizer' => 700, 'polio' => 600, 'sinovac' => 400, 'insulin' => 250]),
            ],
            [
                'id_faskes' => 'PKM-009',
                'nama' => 'Puskesmas Kertapati',
                'kategori' => 'Puskesmas',
                'kecamatan' => 'Kertapati',
                'kulkas_farmasi' => 'Modena 100L',
                'kapasitas_terisi' => 90,
                'suhu_aktual' => 6.5,
                'last_sync' => Carbon::now()->subMinutes(2),
                'stok_vaksin' => json_encode(['totalStok' => 1800, 'kapasitas_total' => 2000, 'pfizer' => 600, 'polio' => 500, 'sinovac' => 500, 'insulin' => 200]),
            ]
        ];

        foreach ($faskesList as $faskes) {
            InventoryHub::create($faskes);
        }
    }
}
