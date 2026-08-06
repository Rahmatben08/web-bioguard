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
        Schema::table('demo_telemetri', function (Blueprint $table) {
            $table->unique(['id_rute', 'timestamp'], 'demo_telemetri_id_rute_timestamp_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demo_telemetri', function (Blueprint $table) {
            $table->dropUnique('demo_telemetri_id_rute_timestamp_unique');
        });
    }
};
