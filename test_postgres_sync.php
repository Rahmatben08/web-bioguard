<?php
require __DIR__."/vendor/autoload.php";
$app = require_once __DIR__."/bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

config([
    "database.default" => "pgsql",
    "database.connections.pgsql" => [
        "driver" => "pgsql",
        "host" => "127.0.0.1",
        "port" => "5432",
        "database" => "bioguard_db",
        "username" => "bioguard_user",
        "password" => "BioGuard2026!",
        "charset" => "utf8",
        "prefix" => "",
        "schema" => "public",
        "sslmode" => "prefer",
    ]
]);

$user = \App\Models\User::first();
auth()->login($user);

$request = \Illuminate\Http\Request::create("/api/sync/telemetri", "POST", [
    "suhu_aktual" => 27.5,
    "latitude" => -2.9378,
    "longitude" => 104.7344,
    "timestamp" => "2026-08-25T07:30:00.000Z",
    "id_rute" => "BOX-TEST"
]);
$request->setUserResolver(function() use ($user) { return $user; });

// Use the proper Request class to trigger validation
$formRequest = \App\Http\Requests\SyncTelemetriRequest::createFrom($request);
$formRequest->setContainer(app());
$formRequest->setRedirector(app(\Illuminate\Routing\Redirector::class));
$formRequest->validateResolved();

$controller = new \App\Http\Controllers\Api\SyncController();
$response = $controller->upsertTelemetri($formRequest);

echo $response->getContent();
