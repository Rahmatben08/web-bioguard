<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$routes = [
    '/dashboard',
    '/dashboard/fleet',
    '/dashboard/sensors',
    '/dashboard/inventory',
    '/dashboard/shipments'
];

foreach ($routes as $uri) {
    $request = Illuminate\Http\Request::create($uri, 'GET');
    // Login as a user (id 1)
    $user = \App\Models\User::find(1);
    $app['auth']->guard()->setUser($user);
    
    $response = $kernel->handle($request);
    
    $status = $response->getStatusCode();
    echo "URL: $uri -> STATUS: $status\n";
    if ($status == 500) {
        // Find error in log
        echo "Error in $uri!\n";
    }
}
