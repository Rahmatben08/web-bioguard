<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();
print_r(App\Models\PerjalananRute::where('status_perjalanan', 'aktif')->get()->pluck('lokasi_tujuan', 'id_box')->toArray());
