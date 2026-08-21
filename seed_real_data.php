<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\InventoryHub;
use App\Models\ThermolabileDrug;

echo "Seeding REAL Faskes and Drugs data...\n";

// Clear previous data
InventoryHub::truncate();
ThermolabileDrug::truncate();

// 1. Seed Faskes (Real data simulation)
$kecamatanList = [
    'Ilir Timur I', 'Ilir Timur II', 'Ilir Barat I', 'Seberang Ulu I', 
    'Plaju', 'Kemuning', 'Sako', 'Sukarami', 'Kalidoni', 'Alang-Alang Lebar'
];

$faskesNames = [
    'RSUD Siti Fatimah', 'RSUP Dr. Mohammad Hoesin', 'RS Pelabuhan Palembang',
    'RS Siloam Sriwijaya', 'RS Hermina Palembang', 'RS Bunda', 'RS RK Charitas',
    'Puskesmas Merdeka', 'Puskesmas Dempo', 'Puskesmas Plaju', 'Puskesmas Sako'
];

$hubs = [];
for ($i = 1; $i <= 60; $i++) {
    $kapasitas = rand(5000, 20000);
    $pfizer = rand(50, 500);
    $polio = rand(100, 1000);
    $sinovac = rand(100, 1000);
    $insulin = rand(200, 2000); // Realistic insulin stock
    
    $totalStok = $pfizer + $polio + $sinovac + $insulin;
    
    // Suhu 2-8 derajat (Aman)
    $suhu = rand(30, 75) / 10.0; // 3.0 to 7.5
    
    // Sesekali buat anomali untuk realism
    if ($i % 15 == 0) {
        $suhu = rand(85, 120) / 10.0; // 8.5 to 12.0 (Bahaya)
    }

    $hubs[] = [
        'id_faskes' => 'F-' . str_pad($i, 5, '0', STR_PAD_LEFT),
        'nama' => $i <= count($faskesNames) ? $faskesNames[$i - 1] : 'Faskes / Klinik ' . $i,
        'kategori' => $i <= 7 ? 'Rumah Sakit' : 'Puskesmas/Klinik',
        'kecamatan' => $kecamatanList[array_rand($kecamatanList)],
        'kulkas_farmasi' => 'BioBase ' . rand(200, 500) . 'L',
        'stok_vaksin' => json_encode([
            'kapasitas_total' => $kapasitas,
            'totalStok' => $totalStok,
            'pfizer' => $pfizer,
            'polio' => $polio,
            'sinovac' => $sinovac,
            'insulin' => $insulin,
        ]),
        'kapasitas_terisi' => round(($totalStok / $kapasitas) * 100),
        'suhu_aktual' => $suhu,
        'last_sync' => now()->subMinutes(rand(1, 60)),
        'created_at' => now(),
        'updated_at' => now(),
    ];
}
InventoryHub::insert($hubs);
echo "Seeded 60 Faskes successfully!\n";

// 2. Seed Obat Termolabil
$drugs = [];
$batchTypes = [
    ['nama' => 'Vaksin Pfizer (COVID-19)', 'jenis' => 'Vaksin mRNA', 'suhu' => -70],
    ['nama' => 'Insulin Novorapid', 'jenis' => 'Insulin', 'suhu' => 4],
    ['nama' => 'Insulin Lantus', 'jenis' => 'Insulin', 'suhu' => 4],
    ['nama' => 'Vaksin Polio (OPV)', 'jenis' => 'Vaksin Hidup', 'suhu' => 2],
    ['nama' => 'Vaksin Sinovac', 'jenis' => 'Vaksin Inaktif', 'suhu' => 5],
    ['nama' => 'Serum Anti-Tetanus', 'jenis' => 'Serum', 'suhu' => 6],
];

for ($i = 1; $i <= 30; $i++) {
    $type = $batchTypes[array_rand($batchTypes)];
    $isKarantina = rand(1, 100) > 90; // 10% karantina
    
    $drugs[] = [
        'no_batch' => 'BATCH-' . date('Ym') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
        'nama_produk' => $type['nama'],
        'jenis' => $type['jenis'],
        'suhu_penyimpanan' => $type['suhu'],
        'stok' => rand(100, 5000),
        'tanggal_kadaluwarsa' => now()->addMonths(rand(1, 24)),
        'status' => $isKarantina ? 'Karantina' : 'Aman',
        'created_at' => now(),
        'updated_at' => now(),
    ];
}
ThermolabileDrug::insert($drugs);
echo "Seeded 30 Obat Termolabil successfully!\n";
echo "DONE!\n";
