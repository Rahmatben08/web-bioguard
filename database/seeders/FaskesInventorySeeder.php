<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryHub;
use Carbon\Carbon;

class FaskesInventorySeeder extends Seeder
{
    public function run()
    {
        DB::table('inventory_hubs')->truncate();

        $kulkasModels = [
            'rs' => ['Modena 500L', 'Modena 300L', 'Gea 300L', 'Samsung 300L', 'Modena 200L'],
            'pkm' => ['Gea 100L', 'Modena 100L', 'Gea 150L', 'Modena 150L'],
        ];

        $faskes = [
            // ========== RUMAH SAKIT (25) ==========
            ['id' => 'RS-001', 'nama' => 'RSUP Dr. Mohammad Hoesin',          'kategori' => 'Rumah Sakit', 'kecamatan' => 'Kemuning'],
            ['id' => 'RS-002', 'nama' => 'RSUD Palembang Bari',               'kategori' => 'Rumah Sakit', 'kecamatan' => 'Seberang Ulu I'],
            ['id' => 'RS-003', 'nama' => 'RSUD Siti Fatimah',                 'kategori' => 'Rumah Sakit', 'kecamatan' => 'Sukarami'],
            ['id' => 'RS-004', 'nama' => 'RSUD Gandus',                       'kategori' => 'Rumah Sakit', 'kecamatan' => 'Gandus'],
            ['id' => 'RS-005', 'nama' => 'RS Ernaldi Bahar',                  'kategori' => 'Rumah Sakit', 'kecamatan' => 'Alang-Alang Lebar'],
            ['id' => 'RS-006', 'nama' => 'RS Dr. AK. Gani',                   'kategori' => 'Rumah Sakit', 'kecamatan' => 'Bukit Kecil'],
            ['id' => 'RS-007', 'nama' => 'RS Islam Siti Khadijah',            'kategori' => 'Rumah Sakit', 'kecamatan' => 'Ilir Barat I'],
            ['id' => 'RS-008', 'nama' => 'RS Charitas',                       'kategori' => 'Rumah Sakit', 'kecamatan' => 'Ilir Timur I'],
            ['id' => 'RS-009', 'nama' => 'RS Siloam Sriwijaya',               'kategori' => 'Rumah Sakit', 'kecamatan' => 'Ilir Barat I'],
            ['id' => 'RS-010', 'nama' => 'RS Hermina Palembang',              'kategori' => 'Rumah Sakit', 'kecamatan' => 'Kemuning'],
            ['id' => 'RS-011', 'nama' => 'RS Hermina OPI Jakabaring',         'kategori' => 'Rumah Sakit', 'kecamatan' => 'Seberang Ulu I'],
            ['id' => 'RS-012', 'nama' => 'RS Bhayangkara Palembang',          'kategori' => 'Rumah Sakit', 'kecamatan' => 'Kemuning'],
            ['id' => 'RS-013', 'nama' => 'RS Bunda Palembang',                'kategori' => 'Rumah Sakit', 'kecamatan' => 'Ilir Barat I'],
            ['id' => 'RS-014', 'nama' => 'RS Ar-Rasyid',                      'kategori' => 'Rumah Sakit', 'kecamatan' => 'Sukarami'],
            ['id' => 'RS-015', 'nama' => 'RS Muhammadiyah Palembang',         'kategori' => 'Rumah Sakit', 'kecamatan' => 'Seberang Ulu I'],
            ['id' => 'RS-016', 'nama' => 'RS Khusus Mata Sumsel',             'kategori' => 'Rumah Sakit', 'kecamatan' => 'Sukarami'],
            ['id' => 'RS-017', 'nama' => 'RS Graha Mandiri',                  'kategori' => 'Rumah Sakit', 'kecamatan' => 'Ilir Barat I'],
            ['id' => 'RS-018', 'nama' => 'RS Karya Asih Charitas',            'kategori' => 'Rumah Sakit', 'kecamatan' => 'Sematang Borang'],
            ['id' => 'RS-019', 'nama' => 'RS Myria',                          'kategori' => 'Rumah Sakit', 'kecamatan' => 'Sukarami'],
            ['id' => 'RS-020', 'nama' => 'RS Pertamina Plaju',                'kategori' => 'Rumah Sakit', 'kecamatan' => 'Plaju'],
            ['id' => 'RS-021', 'nama' => 'RS Sriwijaya',                      'kategori' => 'Rumah Sakit', 'kecamatan' => 'Ilir Timur I'],
            ['id' => 'RS-022', 'nama' => 'RSIA Az-Zahra',                     'kategori' => 'Rumah Sakit', 'kecamatan' => 'Kalidoni'],
            ['id' => 'RS-023', 'nama' => 'RSIA Bunda Noni',                   'kategori' => 'Rumah Sakit', 'kecamatan' => 'Ilir Barat I'],
            ['id' => 'RS-024', 'nama' => 'RSIA Widiyanti',                    'kategori' => 'Rumah Sakit', 'kecamatan' => 'Ilir Timur II'],
            ['id' => 'RS-025', 'nama' => 'RSIA YK Madira',                    'kategori' => 'Rumah Sakit', 'kecamatan' => 'Ilir Timur I'],

            // ========== PUSKESMAS (42) ==========
            ['id' => 'PKM-001', 'nama' => 'Puskesmas Makrayu',                'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Barat II'],
            ['id' => 'PKM-002', 'nama' => 'Puskesmas Sekip',                  'kategori' => 'Puskesmas', 'kecamatan' => 'Kemuning'],
            ['id' => 'PKM-003', 'nama' => 'Puskesmas Punti Kayu',             'kategori' => 'Puskesmas', 'kecamatan' => 'Alang-Alang Lebar'],
            ['id' => 'PKM-004', 'nama' => 'Puskesmas Satu Ulu',               'kategori' => 'Puskesmas', 'kecamatan' => 'Seberang Ulu I'],
            ['id' => 'PKM-005', 'nama' => 'Puskesmas Kampus',                 'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Barat I'],
            ['id' => 'PKM-006', 'nama' => 'Puskesmas Dempo',                  'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Timur I'],
            ['id' => 'PKM-007', 'nama' => 'Puskesmas Karya Jaya',             'kategori' => 'Puskesmas', 'kecamatan' => 'Kertapati'],
            ['id' => 'PKM-008', 'nama' => 'Puskesmas Merdeka',                'kategori' => 'Puskesmas', 'kecamatan' => 'Bukit Kecil'],
            ['id' => 'PKM-009', 'nama' => 'Puskesmas Bukitsangkal',           'kategori' => 'Puskesmas', 'kecamatan' => 'Kalidoni'],
            ['id' => 'PKM-010', 'nama' => 'Puskesmas OPI',                    'kategori' => 'Puskesmas', 'kecamatan' => 'Seberang Ulu I'],
            ['id' => 'PKM-011', 'nama' => 'Puskesmas Sosial',                 'kategori' => 'Puskesmas', 'kecamatan' => 'Sukarami'],
            ['id' => 'PKM-012', 'nama' => 'Puskesmas Lima Ilir',              'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Timur II'],
            ['id' => 'PKM-013', 'nama' => 'Puskesmas Gandus',                 'kategori' => 'Puskesmas', 'kecamatan' => 'Gandus'],
            ['id' => 'PKM-014', 'nama' => 'Puskesmas Multiwahana',            'kategori' => 'Puskesmas', 'kecamatan' => 'Sako'],
            ['id' => 'PKM-015', 'nama' => 'Puskesmas Basuki Rahmat',          'kategori' => 'Puskesmas', 'kecamatan' => 'Kemuning'],
            ['id' => 'PKM-016', 'nama' => 'Puskesmas Keramasan',              'kategori' => 'Puskesmas', 'kecamatan' => 'Kertapati'],
            ['id' => 'PKM-017', 'nama' => 'Puskesmas Padang Selasa',          'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Barat I'],
            ['id' => 'PKM-018', 'nama' => 'Puskesmas Sebelas Ilir',           'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Timur III'],
            ['id' => 'PKM-019', 'nama' => 'Puskesmas Boom Baru',              'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Timur II'],
            ['id' => 'PKM-020', 'nama' => 'Puskesmas Plaju',                  'kategori' => 'Puskesmas', 'kecamatan' => 'Plaju'],
            ['id' => 'PKM-021', 'nama' => 'Puskesmas Pakjo',                  'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Barat I'],
            ['id' => 'PKM-022', 'nama' => 'Puskesmas Tujuh Ulu',              'kategori' => 'Puskesmas', 'kecamatan' => 'Seberang Ulu I'],
            ['id' => 'PKM-023', 'nama' => 'Puskesmas Sabokingking',           'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Timur II'],
            ['id' => 'PKM-024', 'nama' => 'Puskesmas Kalidoni',               'kategori' => 'Puskesmas', 'kecamatan' => 'Kalidoni'],
            ['id' => 'PKM-025', 'nama' => 'Puskesmas Talang Betutu',          'kategori' => 'Puskesmas', 'kecamatan' => 'Sukarami'],
            ['id' => 'PKM-026', 'nama' => 'Puskesmas Ariodillah',             'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Timur I'],
            ['id' => 'PKM-027', 'nama' => 'Puskesmas Sematang Borang',        'kategori' => 'Puskesmas', 'kecamatan' => 'Sematang Borang'],
            ['id' => 'PKM-028', 'nama' => 'Puskesmas Seiselincah',            'kategori' => 'Puskesmas', 'kecamatan' => 'Kalidoni'],
            ['id' => 'PKM-029', 'nama' => 'Puskesmas Nagaswidak',             'kategori' => 'Puskesmas', 'kecamatan' => 'Seberang Ulu II'],
            ['id' => 'PKM-030', 'nama' => 'Puskesmas Kertapati',              'kategori' => 'Puskesmas', 'kecamatan' => 'Kertapati'],
            ['id' => 'PKM-031', 'nama' => 'Puskesmas Alang-Alang Lebar',      'kategori' => 'Puskesmas', 'kecamatan' => 'Alang-Alang Lebar'],
            ['id' => 'PKM-032', 'nama' => 'Puskesmas Talangjambe',            'kategori' => 'Puskesmas', 'kecamatan' => 'Sukarami'],
            ['id' => 'PKM-033', 'nama' => 'Puskesmas Tegal Binangun',         'kategori' => 'Puskesmas', 'kecamatan' => 'Plaju'],
            ['id' => 'PKM-034', 'nama' => 'Puskesmas Sei Baung',              'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Barat I'],
            ['id' => 'PKM-035', 'nama' => 'Puskesmas Sako',                   'kategori' => 'Puskesmas', 'kecamatan' => 'Sako'],
            ['id' => 'PKM-036', 'nama' => 'Puskesmas Sukarami',               'kategori' => 'Puskesmas', 'kecamatan' => 'Sukarami'],
            ['id' => 'PKM-037', 'nama' => 'Puskesmas 23 Ilir',                'kategori' => 'Puskesmas', 'kecamatan' => 'Bukit Kecil'],
            ['id' => 'PKM-038', 'nama' => 'Puskesmas Talang Ratu',            'kategori' => 'Puskesmas', 'kecamatan' => 'Ilir Timur I'],
            ['id' => 'PKM-039', 'nama' => 'Puskesmas Pembina',                'kategori' => 'Puskesmas', 'kecamatan' => 'Seberang Ulu I'],
            ['id' => 'PKM-040', 'nama' => 'Puskesmas Kenten',                 'kategori' => 'Puskesmas', 'kecamatan' => 'Kalidoni'],
            ['id' => 'PKM-041', 'nama' => 'Puskesmas Taman Bacaan',           'kategori' => 'Puskesmas', 'kecamatan' => 'Seberang Ulu II'],
            ['id' => 'PKM-042', 'nama' => 'Puskesmas Empat Ulu',              'kategori' => 'Puskesmas', 'kecamatan' => 'Seberang Ulu I'],
        ];

        $now = Carbon::now();

        foreach ($faskes as $i => $f) {
            $isRS = $f['kategori'] === 'Rumah Sakit';
            $kulkas = $isRS
                ? $kulkasModels['rs'][array_rand($kulkasModels['rs'])]
                : $kulkasModels['pkm'][array_rand($kulkasModels['pkm'])];

            $kapTotal = $isRS ? rand(5000, 15000) : rand(1500, 4000);
            $kapPersen = rand(30, 95);
            $stokTotal = (int) round($kapTotal * ($kapPersen / 100));

            // Distribusi stok vaksin realistis
            $pfizer  = (int) round($stokTotal * (rand(25, 35) / 100));
            $polio   = (int) round($stokTotal * (rand(20, 30) / 100));
            $sinovac = (int) round($stokTotal * (rand(15, 25) / 100));
            $insulin = $stokTotal - $pfizer - $polio - $sinovac;

            // Suhu realistis: mayoritas aman (2-8), beberapa anomali
            $suhu = round(rand(20, 80) / 10, 1); // 2.0 - 8.0
            // ~10% anomali suhu
            if (rand(1, 100) <= 10) {
                $suhu = rand(0, 1) ? round(rand(85, 105) / 10, 1) : round(rand(5, 19) / 10, 1);
            }

            InventoryHub::create([
                'id_faskes'        => $f['id'],
                'nama'             => $f['nama'],
                'kategori'         => $f['kategori'],
                'kecamatan'        => $f['kecamatan'],
                'kulkas_farmasi'   => $kulkas,
                'kapasitas_terisi' => $kapPersen,
                'suhu_aktual'      => $suhu,
                'last_sync'        => $now->copy()->subMinutes(rand(1, 60)),
                'stok_vaksin'      => json_encode([
                    'totalStok'      => $stokTotal,
                    'kapasitas_total' => $kapTotal,
                    'pfizer'         => $pfizer,
                    'polio'          => $polio,
                    'sinovac'        => $sinovac,
                    'insulin'        => $insulin,
                ]),
            ]);
        }
    }
}
