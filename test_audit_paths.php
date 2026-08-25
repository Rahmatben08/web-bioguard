<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::first();
auth()->login($user);

echo "[1] Testing History Endpoint...\n";
$batch = \App\Models\ThermolabileDrug::first();
$response = app(\App\Http\Controllers\ShipmentController::class)->getHistory($batch->no_batch);
echo "Status code for History: " . $response->getStatusCode() . "\n";
echo "Content: " . $response->getContent() . "\n\n";

echo "[2] Testing Audit Stok...\n";
$request = new \Illuminate\Http\Request([
    'no_batch' => $batch->no_batch,
    'qty_fisik' => $batch->stok + 1,
    'keterangan' => 'Test Audit dari Script'
]);
$request->setMethod('POST');
try {
    $auditResponse = app(\App\Http\Controllers\ShipmentController::class)->auditStok($request);
    echo "Audit stok executed successfully.\n";
} catch (\Exception $e) {
    echo "Audit stok failed: " . $e->getMessage() . "\n";
}
echo "New Stok: " . \App\Models\ThermolabileDrug::where('no_batch', $batch->no_batch)->first()->stok . "\n\n";

echo "[3] Testing Checkout / Transfer (Keluarkan Stok)...\n";
$request2 = new \Illuminate\Http\Request([
    'no_batch' => $batch->no_batch,
    'lokasi_tujuan' => 'RS Coba-coba',
    'qty' => 1
]);
$request2->setMethod('POST');
try {
    app(\App\Http\Controllers\ShipmentController::class)->transferBatch($request2);
    echo "Transfer executed successfully.\n";
} catch (\Exception $e) {
    echo "Transfer failed: " . $e->getMessage() . "\n";
}

echo "\n[4] Reverting changes (cleaning up test data)...\n";
$batch->update(['stok' => $batch->stok - 1 + 1]); // just resetting logic theoretically
\App\Models\StockTransaction::where('id_batch', $batch->no_batch)->where('sumber_transaksi', 'koreksi_stok')->delete();
\App\Models\StockTransaction::where('id_batch', $batch->no_batch)->where('sumber_transaksi', 'transfer_stok')->delete();
echo "Cleanup done.\n";
