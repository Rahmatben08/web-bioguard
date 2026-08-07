<?php
$data = ['data' => [
    ['id_rute' => 1, 'timestamp' => '2026-08-06T12:00:00Z', 'suhu_aktual' => 5.5, 'latitude' => -2.9, 'longitude' => 104.7]
]];
$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\nAccept: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
        'ignore_errors' => true
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents('https://bioguard.id/api/demo/sync-telemetri', false, $context);
echo $http_response_header[0] . "\n";
echo $result . "\n";
