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
        Schema::create('thermolabile_drugs', function (Blueprint $table) {
            $table->id();
            $table->string('no_batch')->unique();
            $table->string('nama_produk');
            $table->string('jenis'); // Vaksin, Insulin, Serum Darah, dll.
            $table->integer('stok');
            $table->decimal('suhu_penyimpanan', 5, 2);
            $table->date('tanggal_kadaluwarsa');
            $table->string('status')->default('Aman'); // Aman, Karantina, Peringatan Dini, dll.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thermolabile_drugs');
    }
};
