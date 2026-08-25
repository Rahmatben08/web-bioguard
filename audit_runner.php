<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ThermolabileDrug;
use App\Models\Courier;
use App\Models\InventoryHub;
use Illuminate\Http\Request;

echo "=== BIO-GUARD AUDIT REPORT ===\n\n";

echo "--- BAGIAN 1: WEB ROUTE AUDIT ---\n";
// Create an admin user session
$admin = User::where('email', 'admin@bioguard.id')->first();
if (!$admin) {
    echo "ERROR: admin@bioguard.id not found!\n";
} else {
    auth()->login($admin);
    
    $routes = [
        '/dashboard', '/pengiriman', '/sensor', '/inventaris', 
        '/peringatan', '/armada', '/armada/akun', 
        '/simulator-kurir', '/simulator', '/profil', '/'
    ];
    
    foreach ($routes as $route) {
        try {
            $request = Request::create($route, 'GET');
            $response = app()->handle($request);
            $content = $response->getContent();
            $status = $response->getStatusCode();
            
            $hasError = false;
            if (stripos($content, 'Facade\Ignition') !== false || stripos($content, 'QueryException') !== false) {
                $hasError = true;
            }
            
            echo "[".($status == 200 && !$hasError ? "OK" : "ERROR")."] $route - Status: $status\n";
            if ($hasError) echo "  => Fatal error screen detected in body.\n";
            
        } catch (\Exception $e) {
            echo "[FATAL] $route - Status: 500 - Exception: " . $e->getMessage() . "\n";
        }
    }
}

echo "\n--- BAGIAN 3: DATA & FUNGSI KRITIS ---\n";
// 1. Dashboard Telemetry & AI Prediction widget
echo "1. Checking Dashboard Telemetry for BOX-1:\n";
$box1 = DB::table('sensor_logs')->where('id_box', 'BOX-1')->orderBy('created_at', 'desc')->first();
if ($box1) {
    echo "  [OK] Found telemetry for BOX-1: Temp: {$box1->temperature}, Status: {$box1->status}\n";
} else {
    echo "  [FAIL] No telemetry found for BOX-1.\n";
}

// 2. Data Demo Toggle - just check if is_demo column exists and has values
echo "2. Checking is_demo usage in shipments:\n";
$demoCount = ThermolabileDrug::where('is_demo', true)->count();
$realCount = ThermolabileDrug::where('is_demo', false)->count();
echo "  Demo Shipments: $demoCount, Real Shipments: $realCount\n";

echo "\n--- BAGIAN 3.5: VERIFIKASI CRUD ---\n";

// 1. /armada/akun
echo "1. Courier CRUD Test:\n";
$courier = new Courier();
$courier->name = 'Test Courier Audit';
$courier->phone = '08123456789';
$courier->status = 'Active';
$courier->save();
echo "  [OK] Created Courier ID: {$courier->id}\n";
$courier->status = 'Inactive';
$courier->save();
echo "  [OK] Updated Courier Status to Inactive\n";
$courier->delete();
echo "  [OK] Deleted Courier\n";

// 2. /pengiriman (Batch obat)
echo "2. Shipment CRUD Test:\n";
$drug = new ThermolabileDrug();
$drug->no_batch = 'AUDIT-BATCH-001';
$drug->nama_produk = 'Audit Vaccine';
$drug->jenis = 'Vaksin';
$drug->stok = 1000;
$drug->suhu_penyimpanan = 2.0;
$drug->status = 'Aman';
$drug->tanggal_kadaluwarsa = now()->addYear();
$drug->is_demo = true;
$drug->save();
echo "  [OK] Created Shipment Batch: {$drug->no_batch}\n";
$drug->delete();
echo "  [OK] Deleted Shipment Batch\n";

// 3. /inventaris (Stok Faskes)
echo "3. Inventory Hub CRUD Test:\n";
if (class_exists(InventoryHub::class)) {
    $hub = new InventoryHub();
    $hub->faskes_name = 'RS Audit Test';
    $hub->faskes_type = 'Rumah Sakit';
    $hub->stock_vial = 500;
    $hub->capacity_total = 1000;
    $hub->save();
    echo "  [OK] Created Inventory Hub ID: {$hub->id}\n";
    $hub->stock_vial = 300;
    $hub->save();
    echo "  [OK] Decreased Stock to 300\n";
    $hub->delete();
    echo "  [OK] Deleted Inventory Hub\n";
} else {
    echo "  [FAIL] InventoryHub model does not exist. (Belum diimplementasikan atau nama model berbeda)\n";
}
