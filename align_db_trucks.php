<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\PerjalananRute;
use App\Models\LogTelemetri;

$json = file_get_contents(__DIR__.'/planned_paths.json');
$paths = json_decode($json, true);

if (!$paths) {
    die("Failed to load planned_paths.json\n");
}

$rutes = PerjalananRute::where('status_perjalanan', 'aktif')->get();
foreach($rutes as $rute) {
    $logs = LogTelemetri::where('id_rute', $rute->id_rute)->orderBy('timestamp', 'asc')->get();
    
    $path = $paths[$rute->lokasi_tujuan] ?? null;
    if (!$path || count($path) == 0) {
        echo "No path found for " . $rute->lokasi_tujuan . "\n";
        continue;
    }
    
    $totalPoints = count($path);
    $totalLogs = count($logs);
    
    if ($totalLogs == 0) continue;
    
    // Spread the logs evenly along the path (up to halfway to simulate they are currently traveling)
    // Actually, in the screenshot they were about halfway. Let's just put them at 50% of the route.
    $middleIndex = floor($totalPoints / 2);
    
    $step = 0;
    foreach($logs as $index => $log) {
        // Just linearly interpolate the logs up to the middle of the route
        $targetIndex = floor(($index / max(1, $totalLogs - 1)) * $middleIndex);
        if ($targetIndex >= $totalPoints) $targetIndex = $totalPoints - 1;
        
        $point = $path[$targetIndex];
        $log->latitude = $point[0];
        $log->longitude = $point[1];
        $log->save();
    }
}
echo "Truck locations fully aligned with OSRM arrays.\n";
