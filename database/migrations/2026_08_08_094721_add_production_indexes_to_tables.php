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
        Schema::table('log_telemetri', function (Blueprint $table) {
            $table->index(['id_rute', 'timestamp']);
        });

        Schema::table('perjalanan_rute', function (Blueprint $table) {
            $table->index('status_perjalanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_telemetri', function (Blueprint $table) {
            $table->dropIndex(['id_rute', 'timestamp']);
        });

        Schema::table('perjalanan_rute', function (Blueprint $table) {
            $table->dropIndex(['status_perjalanan']);
        });
    }
};
