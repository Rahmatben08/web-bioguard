<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/api/fleet/live', 'GET', ['show_demo' => 1]);
$response = $kernel->handle($request);
$data = json_decode($response->getContent(), true);

foreach($data['data'] as $c) {
    echo $c['lokasi_tujuan'] . " => " . $c['dest_latitude'] . ", " . $c['dest_longitude'] . "\n";
}
