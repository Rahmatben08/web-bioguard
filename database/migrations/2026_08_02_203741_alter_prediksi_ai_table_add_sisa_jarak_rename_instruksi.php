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
            $table->decimal('sisa_jarak_km', 8, 2)->nullable()->after('id_log');
            $table->renameColumn('rekomendasi_tindakan', 'instruksi_mitigasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prediksi_ai', function (Blueprint $table) {
            $table->dropColumn('sisa_jarak_km');
            $table->renameColumn('instruksi_mitigasi', 'rekomendasi_tindakan');
        });
    }
};
