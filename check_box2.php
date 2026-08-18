<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "--- LANGKAH 1 VERIFIKASI ---\n";

// 1. Cek tabel box atau perjalanan_rute
if (Schema::hasTable('box')) {
    echo "1. Menggunakan tabel 'box'.\n";
    $box1 = DB::table('box')->where('id_box', 'BOX-1')->first();
    echo "Pencarian 'BOX-1' di tabel box: " . ($box1 ? "DITEMUKAN" : "TIDAK DITEMUKAN") . "\n";
    
    $allBoxes = DB::table('box')->pluck('id_box')->toArray();
    echo "Daftar SEMUA id_box di tabel box: \n - " . implode("\n - ", $allBoxes) . "\n";
} else {
    echo "1. Tidak ada tabel 'box'. Memeriksa tabel 'perjalanan_rute'.\n";
    $box1 = DB::table('perjalanan_rute')->where('id_box', 'BOX-1')->first();
    echo "Pencarian 'BOX-1' di tabel perjalanan_rute: " . ($box1 ? "DITEMUKAN" : "TIDAK DITEMUKAN") . "\n";
    
    $allBoxes = DB::table('perjalanan_rute')->pluck('id_box')->unique()->values()->toArray();
    echo "Daftar SEMUA id_box di tabel perjalanan_rute: \n - " . implode("\n - ", $allBoxes) . "\n";
}

// 2. Cek log_telemetri
echo "\n2. Pengecekan tabel log_telemetri untuk 'BOX-1' (orphan):\n";
$teleCols = Schema::getColumnListing('log_telemetri');
if (in_array('id_box', $teleCols)) {
    $orphans = DB::table('log_telemetri')->where('id_box', 'BOX-1')->count();
    echo "Jumlah baris log_telemetri dengan id_box = 'BOX-1': $orphans\n";
} else {
    echo "Tabel log_telemetri tidak memiliki kolom 'id_box'. Telemetri direlasikan melalui 'id_rute'.\n";
    // Check if we can find any route linked to BOX-1
    $ruteIds = DB::table('perjalanan_rute')->where('id_box', 'BOX-1')->pluck('id_rute');
    if ($ruteIds->isEmpty()) {
        echo "Tidak ada id_rute untuk BOX-1, sehingga tidak mungkin ada log_telemetri yang valid untuk BOX-1.\n";
    } else {
        $logsCount = DB::table('log_telemetri')->whereIn('id_rute', $ruteIds)->count();
        echo "Ditemukan $logsCount log_telemetri untuk rute milik BOX-1.\n";
    }
}
