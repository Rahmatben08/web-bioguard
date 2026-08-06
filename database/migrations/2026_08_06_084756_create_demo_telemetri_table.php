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
        Schema::create('demo_telemetri', function (Blueprint $table) {
            $table->bigIncrements('id_log');
            $table->unsignedBigInteger('id_rute');
            $table->dateTime('timestamp');
            $table->decimal('suhu_aktual', 5, 2);
            $table->decimal('nilai_mkt', 5, 2)->nullable();
            $table->double('latitude');
            $table->double('longitude');
            $table->boolean('is_synced_from_offline')->default(false);
            $table->decimal('gaya_guncangan', 4, 2)->default(0.05);

            $table->index('timestamp');
            // We don't cascade on delete for demo to keep it isolated from real 'perjalanan_rute'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_telemetri');
    }
};
