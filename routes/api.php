<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SyncController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Api\AuthController;

// API Login
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Endpoint demo publik (menyimpan ke tabel terpisah demo_telemetri) - Rate limited 1 request per detik (60/menit)
Route::post('/demo/sync-telemetri', [SyncController::class, 'demoSync'])
    ->middleware('throttle:60,1')
    ->name('api.demo.sync');

// Sync Telemetri dari Flutter (Dukungan untuk kedua penamaan route)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/sync/telemetri', [SyncController::class, 'upsertTelemetri'])
        ->name('api.sync.telemetri');
    Route::post('/telemetry/sync', [SyncController::class, 'upsertTelemetri'])
        ->name('api.telemetry.sync');
        
    Route::post('/pairing/validate', [SyncController::class, 'validatePairing'])
        ->name('api.pairing.validate');
});

// Data marker peta (untuk AJAX refresh)
Route::get('/dashboard/map-data', [DashboardController::class, 'mapData'])
    ->name('api.dashboard.map-data');
Route::get('/dashboard/live-data', [DashboardController::class, 'liveData'])
    ->name('api.dashboard.live-data');
Route::get('/fleet/live', [DashboardController::class, 'liveData'])
    ->name('api.fleet.live');

// Live polling endpoints untuk dashboard real-time
Route::get('/shipments/live', [\App\Http\Controllers\ShipmentController::class, 'liveData'])
    ->name('api.shipments.live');
Route::get('/sensors/live', [\App\Http\Controllers\AnalyticsController::class, 'liveData'])
    ->name('api.sensors.live');
Route::get('/alerts/live', [\App\Http\Controllers\AlertController::class, 'liveData'])
    ->name('api.alerts.live');

// Data agregat publik untuk widget landing page
Route::get('/public/stats-ringkas', [DashboardController::class, 'publicStats'])
    ->name('api.public.stats-ringkas');
