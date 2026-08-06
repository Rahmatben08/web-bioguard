<?php
$data = ['id_box' => 'BOX-DEMO-TEST', 'suhu_aktual' => 5.5, 'latitude' => -2.9, 'longitude' => 104.7];
$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data)
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents('https://bioguard.id/api/demo/sync-telemetri', false, $context);
echo $result;
