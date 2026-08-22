<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
if (!$user) {
    echo "No user found\n";
    exit;
}

auth()->login($user);

$request = Illuminate\Http\Request::create('/dashboard', 'GET');
$response = app()->handle($request);

echo "STATUS_CODE: " . $response->status() . "\n";
echo strpos($response->getContent(), "Dasbor Utama") !== false ? "TEXT_FOUND: Dasbor Utama\n" : "TEXT_NOT_FOUND\n";
echo strpos($response->getContent(), "Server Error") !== false ? "ERROR_TEXT_FOUND\n" : "ERROR_TEXT_NOT_FOUND\n";
