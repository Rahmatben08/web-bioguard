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
        Schema::create('batch_transfers', function (Blueprint $table) {
            $table->id('id_transfer');
            $table->string('no_batch', 50);
            $table->string('tujuan_faskes', 150);
            $table->integer('jumlah_transfer');
            $table->unsignedBigInteger('id_admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_transfers');
    }
};
