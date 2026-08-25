<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryHub;
use Carbon\Carbon;

class InventoryHubSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama
        InventoryHub::truncate();

        $kecamatanList = [
            'Ilir Timur I', 'Ilir Timur II', 'Ilir Timur III', 'Ilir Barat I', 'Ilir Barat II',
            'Seberang Ulu I', 'Seberang Ulu II', 'Plaju', 'Kertapati', 'Kemuning', 
            'Sako', 'Sukarami', 'Kalidoni', 'Alang-Alang Lebar', 'Bukit Kecil', 
            'Gandus', 'Jakabaring', 'Sematang Borang'
        ];

        $devices = ['TCW 3000 AC', 'Dometic HT20', 'Vestfrost VLS 024', 'B Medical TCW 80 AC', 'GEA YS-150'];
        
        $hospitals = [
            'RSUP Dr. Mohammad Hoesin', 'RSUD Palembang BARI', 'RSUD Siti Fatimah', 
            'RS Hermina Palembang', 'RS RK Charitas', 'RS Siloam Sriwijaya', 
            'RS Muhammadiyah Palembang', 'RS Bhayangkara M. Hasan', 'RS AK Gani', 
            'RS Pertamina Plaju', 'RS Myria', 'RS Bunda Palembang', 'RS Pelabuhan Palembang',
            'RS Islam Siti Khadijah', 'RS Mata Masyarakat Sumsel', 'RS Ernaldi Bahar',
            'RS YK Madira', 'RS Karya Asih Charitas'
        ];

        $puskesmasNames = [
            'Alang-alang Lebar', 'Ariodillah', 'Basuki Rahmat', 'Boom Baru', 'Bukitsangkal', 'Dempo', 'Dua Puluh Tiga Ilir',
            'Empat Ulu', 'Gandus', 'Kalidoni', 'Kampus', 'Karya Jaya', 'Kenten', 'Keramasan', 'Kertapati', 'Lima Ilir',
            'Makrayu', 'Merdeka', 'Multiwahana', 'Nagaswidak', 'OPI', 'Padang Selasa', 'Pakjo', 'Pembina', 'Plaju',
            'Punti Kayu', 'Sabokingking', 'Sako', 'Satu Ulu', 'Sebelas Ilir', 'Sei Baung', 'Sei Selincah', 'Sekip',
            'Sematang Borang', 'Sosial', 'Sukarami', 'Talang Betutu', 'Talang Ratu', 'Talangjambe', 'Taman Bacaan',
            'Tegal Binangun', 'Tujuh Ulu'
        ];

        // 1. Generate Hospital Hubs (larger capacity)
        foreach ($hospitals as $index => $hospital) {
            $kec = $kecamatanList[$index % count($kecamatanList)];
            
            $pfizer = rand(800, 2500);
            $polio = rand(1500, 4500);
            $sinovac = rand(2000, 6000);
            $insulin = rand(400, 1200);
            $totalStok = $pfizer + $polio + $sinovac + $insulin;
            $kapasitas = rand(15000, 20000);
            $suhu = round(2.5 + ($index * 0.4) % 5.0, 1);

            InventoryHub::create([
                'id_faskes' => 'HOSP-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $hospital,
                'kategori' => 'Rumah Sakit',
                'kecamatan' => $kec,
                'kulkas_farmasi' => 'B Medical TCW 4000 SDD',
                'suhu_aktual' => $suhu,
                'kapasitas_terisi' => round(($totalStok / $kapasitas) * 100, 1),
                'last_sync' => Carbon::now()->subMinutes(rand(1, 15)),
                'stok_vaksin' => [
                    'pfizer' => $pfizer,
                    'polio' => $polio,
                    'sinovac' => $sinovac,
                    'insulin' => $insulin,
                    'totalStok' => $totalStok,
                    'kapasitas_total' => $kapasitas
                ],
            ]);
        }

        // 2. Generate Puskesmas Hubs (medium capacity)
        foreach ($puskesmasNames as $index => $name) {
            $kec = $kecamatanList[($index + 3) % count($kecamatanList)];
            $device = $devices[$index % count($devices)];
            
            $pfizer = rand(100, 600);
            $polio = rand(300, 1200);
            $sinovac = rand(500, 2000);
            $insulin = rand(50, 400);
            $totalStok = $pfizer + $polio + $sinovac + $insulin;
            $kapasitas = rand(4500, 6000);
            
            if ($index === 7) {
                $suhu = 8.9; 
            } elseif ($index === 23) {
                $suhu = 1.4; 
            } else {
                $suhu = round(3.0 + (sin($index) * 2.0) + 1.5, 1);
            }

            InventoryHub::create([
                'id_faskes' => 'PKM-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'nama' => 'Puskesmas ' . $name,
                'kategori' => 'Puskesmas',
                'kecamatan' => $kec,
                'kulkas_farmasi' => $device,
                'suhu_aktual' => $suhu,
                'kapasitas_terisi' => round(($totalStok / $kapasitas) * 100, 1),
                'last_sync' => Carbon::now()->subMinutes(rand(1, 45)),
                'stok_vaksin' => [
                    'pfizer' => $pfizer,
                    'polio' => $polio,
                    'sinovac' => $sinovac,
                    'insulin' => $insulin,
                    'totalStok' => $totalStok,
                    'kapasitas_total' => $kapasitas
                ],
            ]);
        }
    }
}