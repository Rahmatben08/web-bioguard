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

    Route::get('/dashboard/qr-batch/{batch_id}', [DashboardController::class, 'generateBatchQr'])
        ->name('dashboard.qr_batch');

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

    Route::get('/dashboard/fleet/live-location', [FleetController::class, 'liveLocation'])
        ->name('fleet.live');

    Route::get('/armada', [FleetController::class, 'index'])
        ->name('fleet');
    Route::post('/armada/kurir', [FleetController::class, 'storeKurir'])
        ->name('fleet.storeKurir');

    // Kelola Akun Kurir Routes (Protected for admin only)
    Route::prefix('armada/akun')->group(function () {
        Route::get('/', [FleetController::class, 'accounts'])->name('fleet.accounts');
        Route::post('/{id}/buat-akun', [FleetController::class, 'buatAkun'])->name('fleet.accounts.create');
        Route::post('/{id}/reset-password', [FleetController::class, 'resetPassword'])->name('fleet.accounts.reset');
        Route::post('/{id}/toggle-status', [FleetController::class, 'toggleStatus'])->name('fleet.accounts.toggle');
    });
    
    Route::post('/pengiriman', [ShipmentController::class, 'store'])
        ->name('shipments.store');
    
    // Quick Actions Routes
    Route::post('/pengiriman/terima', [ShipmentController::class, 'terimaPengiriman'])
        ->name('shipments.terima');
    Route::post('/pengiriman/audit', [ShipmentController::class, 'auditStok'])
        ->name('shipments.audit');
    Route::post('/pengiriman/transfer', [ShipmentController::class, 'transferBatch'])
        ->name('shipments.transfer');
    Route::post('/pengiriman/lapor', [ShipmentController::class, 'laporSelisih'])
        ->name('shipments.lapor');
    Route::post('/pengiriman/restok', [ShipmentController::class, 'aturanRestok'])
        ->name('shipments.restok');

    Route::get('/profil', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profil', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profil/regenerate-key', [AdminController::class, 'regenerateApiKey'])->name('profile.regenerate-key');

    // ==========================================
    // SIMULATOR ROUTES (INTERNAL ADMIN)
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
        
        // Hapus token lama untuk simulator ini (jika ada) agar tidak menumpuk
        auth()->user()->tokens()->where('name', 'simulator-internal')->delete();
        
        // Generate temporary Sanctum token for this session to authorize API calls
        $apiToken = auth()->user()->createToken('simulator-internal')->plainTextToken;

        return view('dashboard.simulator', compact('ruteAktif', 'apiToken'));
    })->name('simulator.integrated');
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



