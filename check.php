<?php 
require 'vendor/autoload.php'; 
$app = require_once 'bootstrap/app.php'; 
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); 

echo 'LogTelemetri count: ' . App\Models\LogTelemetri::count() . "\n"; 
if (\Illuminate\Support\Facades\Schema::hasTable('demo_telemetri')) {
    echo 'DemoTelemetri count: ' . DB::table('demo_telemetri')->count() . "\n"; 
} else {
    echo "demo_telemetri table does not exist.\n";
}
