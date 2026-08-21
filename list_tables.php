<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$tables = Illuminate\Support\Facades\DB::select("SELECT name FROM sqlite_master WHERE type='table'");
foreach($tables as $t) {
    echo $t->name . "\n";
}
