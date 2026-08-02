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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->default('admin')->after('password');
            $table->unsignedBigInteger('id_kurir')->nullable()->after('role');
            
            // Optional: Foreign key constraint if you want strict referential integrity
            // $table->foreign('id_kurir')->references('id_kurir')->on('kurir')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'id_kurir']);
        });
    }
};
