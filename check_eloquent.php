<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$perjalanan = \App\Models\PerjalananRute::find(1);
$faskes = \App\Models\InventoryHub::where('nama', $perjalanan->lokasi_tujuan)->first();
echo "Tujuan: '" . $perjalanan->lokasi_tujuan . "'\n";
echo "Faskes Name: '" . ($faskes ? $faskes->nama : "NULL") . "'\n";
echo "Lat: " . ($faskes ? $faskes->latitude : "NULL") . "\n";
