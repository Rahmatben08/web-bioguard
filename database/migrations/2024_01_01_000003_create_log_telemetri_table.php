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
        Schema::create('log_telemetri', function (Blueprint $table) {
            $table->bigIncrements('id_log');
            $table->unsignedBigInteger('id_rute');
            $table->dateTime('timestamp');
            $table->decimal('suhu_aktual', 5, 2);
            $table->decimal('nilai_mkt', 5, 2)->nullable();
            $table->double('latitude');
            $table->double('longitude');
            $table->boolean('is_synced_from_offline')->default(false);
            $table->decimal('gaya_guncangan', 4, 2)->default(0.05);

            // Indexes and Foreign Keys
            $table->foreign('id_rute')
                  ->references('id_rute')
                  ->on('perjalanan_rute')
                  ->onDelete('cascade');

            $table->index('timestamp');
            $table->unique(['id_rute', 'timestamp']); // To prevent duplicates for the same route at the same time
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_telemetri');
    }
};
