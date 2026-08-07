<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
echo 'LogTelemetri: ' . \App\Models\LogTelemetri::count() . "\n";
echo 'DemoTelemetri: ' . \DB::table('demo_telemetri')->count() . "\n";
