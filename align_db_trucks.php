<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\PerjalananRute;
use App\Models\LogTelemetri;

// OSRM route for RSUP
$rsupRoute = [
    [-2.973283, 104.755628],
    [-2.973121, 104.755632],
    [-2.972322, 104.755291],
    [-2.970878, 104.752538],
    [-2.969057, 104.752524]
];

// OSRM route for RSUD BARI (approx from Dinkes)
$rsudRoute = [
    [-2.973283, 104.755628],
    [-2.9880, 104.7560],
    [-2.9912, 104.7592],
    [-2.9961, 104.7628]
];

$rutes = PerjalananRute::where('status_perjalanan', 'aktif')->get();
foreach($rutes as $rute) {
    $logs = LogTelemetri::where('id_rute', $rute->id_rute)->orderBy('timestamp', 'asc')->get();
    
    $path = ($rute->lokasi_tujuan == 'RSUP Dr. Mohammad Hoesin') ? $rsupRoute : $rsudRoute;
    $step = 0;
    
    foreach($logs as $log) {
        $point = $path[min($step, count($path) - 1)];
        $log->latitude = $point[0];
        $log->longitude = $point[1];
        $log->save();
        $step++;
    }
}
echo "Updated truck locations in DB to match roads.\n";
