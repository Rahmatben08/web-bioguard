<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AdminController;

use App\Models\Kurir;
use App\Models\PerjalananRute;
use App\Models\IncidentLog;

Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminController::class, 'login']);
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/simulator', function () {
    // Ambil rute perjalanan aktif beserta kurirnya
    $ruteAktif = PerjalananRute::with('kurir')->aktif()->get();

    // Jika kosong, buat seeder dummy otomatis
    if ($ruteAktif->isEmpty()) {
        $kurir = Kurir::firstOrCreate(
            ['nama_lengkap' => 'Budi Santoso'],
            ['nomor_kendaraan' => 'BG 1945 PKM']
        );

        $dummyRute = PerjalananRute::create([
            'id_kurir' => $kurir->id_kurir,
            'id_box' => 'BOX-IOT-PKM-01',
            'nama_kargo' => 'Vaksin Polio & BCG',
            'lokasi_tujuan' => 'RSUP Dr. Mohammad Hoesin',
            'status_perjalanan' => 'aktif',
        ]);

        $ruteAktif = collect([$dummyRute->load('kurir')]);
    }

    return view('simulator', compact('ruteAktif'));
})->name('simulator.standalone');

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/export', [DashboardController::class, 'exportTelemetryToExcel'])
        ->name('dashboard.export');

    Route::get('/dashboard/audit-pdf', [DashboardController::class, 'printAuditTrail'])
        ->name('dashboard.audit-pdf');

    Route::get('/dashboard/qr/{id_box}', [DashboardController::class, 'generateBoxQr'])
        ->name('dashboard.qr');

    Route::get('/pengiriman', [ShipmentController::class, 'index'])
        ->name('shipments');

    Route::get('/sensor', [AnalyticsController::class, 'index'])
        ->name('sensors');

    Route::get('/inventaris', [InventoryController::class, 'index'])
        ->name('inventory');

    Route::get('/peringatan', [AlertController::class, 'index'])
        ->name('alerts');

    Route::post('/peringatan/{id}/resolve', [AlertController::class, 'resolve'])
        ->name('alerts.resolve');

    Route::get('/api/fleet/live-location', [FleetController::class, 'liveLocation'])
        ->name('fleet.live');

    Route::get('/armada', [FleetController::class, 'index'])
        ->name('fleet');

    Route::get('/profil', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profil', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profil/regenerate-key', [AdminController::class, 'regenerateApiKey'])->name('profile.regenerate-key');
});

// Fallback redirects for old paths to prevent 404s
Route::redirect('/shipments', '/pengiriman');
Route::redirect('/sensors', '/sensor');
Route::redirect('/alerts', '/peringatan');
Route::redirect('/fleet', '/armada');
Route::redirect('/simulasi', '/simulator');


// ==========================================
// SIMULATOR ROUTES
// ==========================================
Route::get('/simulasi-kurir', function () {
    // Ambil rute perjalanan aktif beserta kurirnya
    $ruteAktif = PerjalananRute::with('kurir')->aktif()->get();

    // Jika kosong, buat seeder dummy otomatis
    if ($ruteAktif->isEmpty()) {
        $kurir = Kurir::firstOrCreate(
            ['nama_lengkap' => 'Budi Santoso'],
            ['nomor_kendaraan' => 'BG 1945 PKM']
        );

        $dummyRute = PerjalananRute::create([
            'id_kurir' => $kurir->id_kurir,
            'id_box' => 'BOX-IOT-PKM-01',
            'nama_kargo' => 'Vaksin Polio & BCG',
            'lokasi_tujuan' => 'RSUP Dr. Mohammad Hoesin',
            'status_perjalanan' => 'aktif',
        ]);

        $ruteAktif = collect([$dummyRute->load('kurir')]);
    }

    return view('dashboard.simulator', compact('ruteAktif'));
})->name('simulator.integrated');

Route::post('/api/simulasi/sos', function (\Illuminate\Http\Request $request) {
    $id_rute = $request->input('id_rute');
    $jenis_insiden = $request->input('jenis_insiden'); // 'Kemacetan Ekstrem' atau 'Boks Bocor'
    $deskripsi = $request->input('deskripsi', 'Pemicu SOS Darurat');
    $suhu = $request->input('suhu_tercatat', 5.0);

    // Cari perjalanan
    $rute = PerjalananRute::find($id_rute) ?? PerjalananRute::aktif()->first();

    if (!$rute) {
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada rute perjalanan aktif untuk dilaporkan.'
        ], 400);
    }

    // Buat IncidentLog baru
    $incident = IncidentLog::create([
        'id_rute' => $rute->id_rute,
        'jenis_insiden' => $jenis_insiden,
        'deskripsi' => $deskripsi . ' (Dilaporkan Kurir via Tombol SOS)',
        'suhu_tercatat' => $suhu,
        'durasi_anomali' => 0,
        'status' => 'aktif',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Laporan SOS Darurat berhasil dikirim ke Pusat Kendali!',
        'data' => $incident
    ]);
});

Route::post('/api/route/{id}/complete', [DashboardController::class, 'completeRoute'])->name('route.complete');

// Programmatic helper routes for Shared Hosting deployment
Route::get('/run-migration', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true
        ]);
        return 'Sukses: Database Migration & Seeding berhasil dilakukan!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/run-symlink', function() {
    try {
        $target = storage_path('app/public');
        $link = public_path('storage');
        
        // Helper function for recursive copy
        $copyRecursive = function($src, $dst) use (&$copyRecursive) {
            if (!is_dir($src)) return;
            if (!is_dir($dst)) {
                mkdir($dst, 0777, true);
            }
            $files = array_diff(scandir($src), ['.', '..']);
            foreach ($files as $file) {
                $srcPath = $src . '/' . $file;
                $dstPath = $dst . '/' . $file;
                if (is_dir($srcPath)) {
                    $copyRecursive($srcPath, $dstPath);
                } else {
                    copy($srcPath, $dstPath);
                }
            }
        };

        // Perform copy bypass
        $copyRecursive($target, $link);
        
        return 'Sukses: Folder storage dan isinya berhasil disalin secara fisik ke public_html/storage!';
    } catch (\Throwable $e) {
        return 'Error: ' . $e->getMessage() . ' (di ' . $e->getFile() . ' baris ' . $e->getLine() . ')';
    }
});


