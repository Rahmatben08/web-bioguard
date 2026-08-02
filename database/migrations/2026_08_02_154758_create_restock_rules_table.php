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
        Schema::create('restock_rules', function (Blueprint $table) {
            $table->id('id_rule');
            $table->string('jenis_obat', 100)->unique();
            $table->integer('ambang_minimum');
            $table->integer('jumlah_restok_disarankan');
            $table->unsignedBigInteger('id_admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restock_rules');
    }
};
