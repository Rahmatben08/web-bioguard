<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_hubs', function (Blueprint $table) {
            $table->id();
            $table->string('id_faskes')->unique();
            $table->string('nama');
            $table->string('kategori'); // RS atau Puskesmas
            $table->string('kecamatan');
            $table->string('kulkas_farmasi');
            $table->decimal('suhu_aktual', 4, 1)->default(4.5);
            $table->decimal('kapasitas_terisi', 5, 2)->default(0.00); // persentase
            $table->timestamp('last_sync')->nullable();
            $table->json('stok_vaksin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_hubs');
    }
};
