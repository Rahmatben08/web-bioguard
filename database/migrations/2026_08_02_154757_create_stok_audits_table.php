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
        Schema::create('stok_audits', function (Blueprint $table) {
            $table->id('id_audit');
            $table->string('no_batch', 50);
            $table->integer('stok_sistem');
            $table->integer('stok_fisik');
            $table->integer('selisih');
            $table->unsignedBigInteger('id_admin');
            $table->timestamps();

            // Foreign keys if necessary
            // $table->foreign('no_batch')->references('no_batch')->on('thermolabile_drugs');
            // $table->foreign('id_admin')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_audits');
    }
};
