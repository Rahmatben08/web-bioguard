<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "1. Table box check:\n";
if (Schema::hasTable('box')) {
    $boxes = DB::table('box')->get();
    echo "Has 'box' table.\n";
    foreach ($boxes as $b) { echo "- " . json_encode($b) . "\n"; }
} else {
    echo "NO 'box' table found.\n";
    echo "Checking 'perjalanan_rute' table for id_box...\n";
    $rutes = DB::table('perjalanan_rute')->select('id_box', 'status')->get();
    foreach ($rutes as $r) { echo "- id_box: {$r->id_box}, status: {$r->status}\n"; }
}

echo "\n2. Check log_telemetri for BOX-1:\n";
// telemetri doesn't have id_box directly usually, it has id_rute. Let's check schema.
$telemetriCols = Schema::getColumnListing('log_telemetri');
echo "Telemetri columns: " . implode(', ', $telemetriCols) . "\n";
if (in_array('id_box', $telemetriCols)) {
    $orphans = DB::table('log_telemetri')->where('id_box', 'BOX-1')->get();
    echo "Orphan log_telemetri for BOX-1: " . count($orphans) . " rows\n";
} else {
    echo "log_telemetri does not have 'id_box' column.\n";
}

