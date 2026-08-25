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
        // Drop old unused stock_ledgers table to avoid duplicate functionality
        Schema::dropIfExists('stock_ledgers');

        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('id_batch', 50); // FK ke thermolabile_drugs.no_batch
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->enum('sumber_transaksi', ['serah_terima_kurir', 'input_manual_admin', 'koreksi_stok']);
            $table->string('id_referensi', 50)->nullable(); // FK ke perjalanan_rute jika dari kurir
            $table->timestamp('waktu_transaksi')->useCurrent();
            $table->unsignedBigInteger('dilakukan_oleh')->nullable(); // FK ke users.id
            $table->timestamps();

            // Setup foreign keys (if referenced tables/columns exist with matching types)
            $table->foreign('id_batch')->references('no_batch')->on('thermolabile_drugs')->onDelete('cascade');
            $table->foreign('dilakukan_oleh')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
        
        // Optionally recreate stock_ledgers in down() if needed, but not strictly necessary here.
    }
};
