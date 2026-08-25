<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$batch = \App\Models\ThermolabileDrug::first();
echo "Memilih Batch: " . $batch->no_batch . "\n";

echo "Mencatat transaksi uji coba...\n";
$tx = \App\Models\StockTransaction::create([
    'id_batch' => $batch->no_batch,
    'tipe' => 'masuk',
    'jumlah' => 10,
    'sumber_transaksi' => 'input_manual_admin',
    'dilakukan_oleh' => 1
]);

echo "Transaksi tercatat dengan ID: " . $tx->id . " - Tipe: " . $tx->tipe . " - Jumlah: " . $tx->jumlah . "\n";
echo "Menghapus transaksi uji coba...\n";
$tx->delete();
echo "Verifikasi selesai!\n";
