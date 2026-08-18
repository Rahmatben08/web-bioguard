<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Users:\n";
echo App\Models\User::where('role', 'kurir')->get() . "\n";
echo "Routes:\n";
echo App\Models\PerjalananRute::get() . "\n";
echo "Kurirs:\n";
echo App\Models\Kurir::get() . "\n";
