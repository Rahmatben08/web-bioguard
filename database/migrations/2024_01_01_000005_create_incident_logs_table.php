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
        Schema::create('incident_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rute');
            $table->string('jenis_insiden');
            $table->string('deskripsi');
            $table->decimal('suhu_tercatat', 5, 2);
            $table->integer('durasi_anomali');
            $table->string('status')->default('aktif'); // aktif, resolved
            $table->timestamps();

            $table->foreign('id_rute')
                  ->references('id_rute')
                  ->on('perjalanan_rute')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_logs');
    }
};
