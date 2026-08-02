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
        Schema::create('perjalanan_rute', function (Blueprint $table) {
            $table->bigIncrements('id_rute');
            $table->unsignedBigInteger('id_kurir');
            $table->string('id_box', 50);
            $table->string('nama_kargo', 100)->default('Vaksin');
            $table->string('lokasi_tujuan', 255);
            $table->string('status_perjalanan', 20)->default('aktif');
            $table->timestamps();

            // Foreign Key constraint
            $table->foreign('id_kurir')
                  ->references('id_kurir')
                  ->on('kurir')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perjalanan_rute');
    }
};
