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
        Schema::create('prediksi_ai', function (Blueprint $table) {
            $table->bigIncrements('id_prediksi');
            $table->unsignedBigInteger('id_log')->unique();
            $table->decimal('probabilitas_rusak', 5, 2); // 0.00 to 100.00 %
            $table->string('rekomendasi_tindakan', 255)->nullable();
            $table->timestamps();

            // Foreign Key constraint
            $table->foreign('id_log')
                  ->references('id_log')
                  ->on('log_telemetri')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediksi_ai');
    }
};
