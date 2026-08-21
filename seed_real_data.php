<?php

require __DIR__.'/vendor/autoload.php';
\ = require_once __DIR__.'/bootstrap/app.php';
\->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\InventoryHub;
use App\Models\ThermolabileDrug;

echo "Seeding REAL Faskes and Drugs data...\n";

// Clear previous data
InventoryHub::truncate();
ThermolabileDrug::truncate();

// 1. Seed Faskes (Real data simulation)
\ = [
    'Ilir Timur I', 'Ilir Timur II', 'Ilir Barat I', 'Seberang Ulu I', 
    'Plaju', 'Kemuning', 'Sako', 'Sukarami', 'Kalidoni', 'Alang-Alang Lebar'
];

\ = [
    'RSUD Siti Fatimah', 'RSUP Dr. Mohammad Hoesin', 'RS Pelabuhan Palembang',
    'RS Siloam Sriwijaya', 'RS Hermina Palembang', 'RS Bunda', 'RS RK Charitas',
    'Puskesmas Merdeka', 'Puskesmas Dempo', 'Puskesmas Plaju', 'Puskesmas Sako'
];

\ = [];
for (\ = 1; \ <= 60; \++) {
    \ = rand(5000, 20000);
    \ = rand(50, 500);
    \ = rand(100, 1000);
    \ = rand(100, 1000);
    \ = rand(200, 2000); // Realistic insulin stock
    
    \ = \ + \ + \ + \;
    
    // Suhu 2-8 derajat (Aman)
    \ = rand(30, 75) / 10.0; // 3.0 to 7.5
    
    // Sesekali buat anomali untuk realism
    if (\ % 15 == 0) {
        \ = rand(85, 120) / 10.0; // 8.5 to 12.0 (Bahaya)
    }

    \[] = [
        'id_faskes' => 'F-' . str_pad(\, 5, '0', STR_PAD_LEFT),
        'nama' => \ <= count(\) ? \[\ - 1] : 'Faskes / Klinik ' . \,
        'kategori' => \ <= 7 ? 'Rumah Sakit' : 'Puskesmas/Klinik',
        'kecamatan' => \[array_rand(\)],
        'kulkas_farmasi' => 'BioBase ' . rand(200, 500) . 'L',
        'stok_vaksin' => json_encode([
            'kapasitas_total' => \,
            'totalStok' => \,
            'pfizer' => \,
            'polio' => \,
            'sinovac' => \,
            'insulin' => \,
        ]),
        'kapasitas_terisi' => round((\ / \) * 100),
        'suhu_aktual' => \,
        'last_sync' => now()->subMinutes(rand(1, 60)),
        'created_at' => now(),
        'updated_at' => now(),
    ];
}
InventoryHub::insert(\);
echo "Seeded 60 Faskes successfully!\n";

// 2. Seed Obat Termolabil
\ = [];
\ = [
    ['nama' => 'Vaksin Pfizer (COVID-19)', 'jenis' => 'Vaksin mRNA', 'suhu' => -70],
    ['nama' => 'Insulin Novorapid', 'jenis' => 'Insulin', 'suhu' => 4],
    ['nama' => 'Insulin Lantus', 'jenis' => 'Insulin', 'suhu' => 4],
    ['nama' => 'Vaksin Polio (OPV)', 'jenis' => 'Vaksin Hidup', 'suhu' => 2],
    ['nama' => 'Vaksin Sinovac', 'jenis' => 'Vaksin Inaktif', 'suhu' => 5],
    ['nama' => 'Serum Anti-Tetanus', 'jenis' => 'Serum', 'suhu' => 6],
];

for (\ = 1; \ <= 30; \++) {
    \ = \[array_rand(\)];
    \ = rand(1, 100) > 90; // 10% karantina
    
    \[] = [
        'no_batch' => 'BATCH-' . date('Ym') . '-' . str_pad(\, 4, '0', STR_PAD_LEFT),
        'nama_produk' => \['nama'],
        'jenis' => \['jenis'],
        'suhu_penyimpanan' => \['suhu'],
        'stok' => rand(100, 5000),
        'tanggal_kadaluwarsa' => now()->addMonths(rand(1, 24)),
        'status' => \ ? 'Karantina' : 'Aman',
        'created_at' => now(),
        'updated_at' => now(),
    ];
}
ThermolabileDrug::insert(\);
echo "Seeded 30 Obat Termolabil successfully!\n";
echo "DONE!\n";
