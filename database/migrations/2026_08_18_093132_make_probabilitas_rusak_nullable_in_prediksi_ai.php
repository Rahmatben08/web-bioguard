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
        Schema::table('prediksi_ai', function (Blueprint $table) {
            // Make it nullable to support fallback state when AI API is down
            $table->decimal('probabilitas_rusak', 5, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prediksi_ai', function (Blueprint $table) {
            $table->decimal('probabilitas_rusak', 5, 2)->nullable(false)->change();
        });
    }
};
