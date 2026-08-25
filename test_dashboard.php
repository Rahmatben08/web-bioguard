<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$uri = $argv[1] ?? '/dashboard';
$request = Illuminate\Http\Request::create($uri, 'GET');
$user = \App\Models\User::find(1);
$app['auth']->guard()->setUser($user);
$response = $kernel->handle($request);
$status = $response->getStatusCode();
echo "STATUS_CODE: $status\n";
