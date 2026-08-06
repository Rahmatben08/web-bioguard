<?php
$url = "https://router.project-osrm.org/route/v1/driving/104.755490,-2.973305;104.747123,-2.966964?overview=full&geometries=geojson";
$json = file_get_contents($url);
$data = json_decode($json, true);
$coords = $data['routes'][0]['geometry']['coordinates'];

$latLngs = [];
foreach($coords as $coord) {
    $latLngs[] = "            [" . $coord[1] . ", " . $coord[0] . "]";
}
$replacement = implode(",\n", $latLngs);

// In simulator.blade.php
$file = 'resources/views/dashboard/simulator.blade.php';
$content = file_get_contents($file);
$pattern = '/let routeCoords = \[\s*\[-2\.973305, 104\.755490\],[\s\S]*?\[-2\.969305, 104\.752490\], \/\/ RSUP Moh Hoesin\s*\];/';
$newCoordsArray = "let routeCoords = [\n$replacement\n        ];";
$newContent = preg_replace($pattern, $newCoordsArray, $content);
file_put_contents($file, $newContent);

// In monitoring.blade.php
$file2 = 'resources/views/dashboard/monitoring.blade.php';
$content2 = file_get_contents($file2);
$pattern2 = '/\'RSUP Dr\. Mohammad Hoesin\': \[\s*\[-2\.9733, 104\.7555\], \[-2\.969, 104\.752\]\s*\]/';
$newCoordsArray2 = "'RSUP Dr. Mohammad Hoesin': [\n$replacement\n        ]";
$newContent2 = preg_replace($pattern2, $newCoordsArray2, $content2);
file_put_contents($file2, $newContent2);

echo "Replaced routes in both files.\n";
