<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            
            // Menggunakan string agar kompatibel sempurna dengan SQLite (pengganti enum)
            // type bisa bernilai: 'in', 'out', 'adjustment'
            $table->string('type');
            
            // Jumlah barang yang berubah (sebaiknya absolute value)
            $table->integer('quantity');
            
            // Referensi (bisa null jika penyesuaian independen)
            $table->string('reference_batch')->nullable()->index();
            $table->string('reference_faskes')->nullable()->index();
            $table->string('route_id')->nullable()->index(); // ID PerjalananRute jika dari kurir
            
            // Siapa/apa yang men-trigger perubahan ini
            $table->string('trigger_by')->default('system'); // 'system', 'admin', 'kurir'
            $table->unsignedBigInteger('trigger_user_id')->nullable(); // ID User terkait
            
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // SQLite CHECK constraints untuk simulasi ENUM
            // Ini akan memastikan data valid meski tanpa enum DB bawaan
            // Karena SQLite tidak mendukung alter constraints dengan mudah, pastikan benar.
            // NOTE: Blueprint Laravel tidak mendukung native check() pada column fluent definition 
            // untuk SQLite dengan lancar di beberapa versi, jadi lebih aman tidak perlu DB-level check, 
            // cukup di layer Model.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ledgers');
    }
};
