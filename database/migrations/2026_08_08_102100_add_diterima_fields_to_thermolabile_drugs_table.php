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
        Schema::table('thermolabile_drugs', function (Blueprint $table) {
            $table->unsignedBigInteger('diterima_oleh')->nullable();
            $table->timestamp('diterima_pada')->nullable();
            
            $table->foreign('diterima_oleh')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thermolabile_drugs', function (Blueprint $table) {
            $table->dropForeign(['diterima_oleh']);
            $table->dropColumn(['diterima_oleh', 'diterima_pada']);
        });
    }
};
