<?php
require __DIR__."/vendor/autoload.php";
$app = require_once __DIR__."/bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$tables = [
    "users",
    "kurir",
    "perjalanan_rute",
    "log_telemetri",
    "prediksi_ai",
    "incident_logs",
    "thermolabile_drugs",
    "stok_audits",
    "batch_transfers",
    "restock_rules",
    "demo_telemetri",
    "devices",
    "inventory_hubs",
    "stock_ledgers"
];

// Provide testing environment to get pgsql connection configuration
config([
    "database.default" => "sqlite",
    "database.connections.pgsql" => [
        'driver' => 'pgsql',
        'host' => '127.0.0.1',
        'port' => '5432',
        'database' => 'bioguard_db',
        'username' => 'bioguard_user',
        'password' => 'BioGuard2026!',
        'charset' => 'utf8',
        'prefix' => '',
        'schema' => 'public',
        'sslmode' => 'prefer',
    ]
]);

foreach ($tables as $table) {
    echo "Migrating table: $table...\n";
    try {
        $rows = DB::connection("sqlite")->table($table)->get();
    } catch (\Exception $e) {
        echo "  Table $table not found in SQLite, skipping.\n";
        continue;
    }
    
    $chunks = $rows->chunk(500);
    $total = 0;
    foreach ($chunks as $chunk) {
        $insertData = [];
        foreach ($chunk as $row) {
            $insertData[] = (array) $row;
        }
        
        if (!empty($insertData)) {
            try {
                DB::connection("pgsql")->table($table)->insertOrIgnore($insertData);
            } catch (\Exception $e) {
                // if insertOrIgnore is not supported, fallback to looping
                foreach ($insertData as $row) {
                    try {
                        DB::connection("pgsql")->table($table)->insert($row);
                    } catch (\Exception $e2) {
                        // ignore duplicate
                    }
                }
            }
            $total += count($insertData);
        }
    }
    
    // Sync sequence (for auto-increment) in Postgres
    if ($total > 0) {
        $pk = "id";
        if ($table === "log_telemetri") $pk = "id_log";
        if ($table === "perjalanan_rute") $pk = "id_rute";
        if ($table === "kurir") $pk = "id_kurir";
        
        if (Schema::connection("pgsql")->hasColumn($table, $pk)) {
            $maxId = DB::connection("pgsql")->table($table)->max($pk);
            if ($maxId) {
                DB::connection("pgsql")->statement("SELECT setval(pg_get_serial_sequence('$table', '$pk'), $maxId)");
            }
        }
    }
    
    echo "  Inserted $total rows.\n";
}
echo "Migration complete.\n";
