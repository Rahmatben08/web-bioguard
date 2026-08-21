<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('devices')) {
            Schema::create('devices', function (Blueprint $table) {
                $table->id();
                $table->string('id_box', 50)->unique();
                $table->boolean('is_validated')->default(true);
                $table->date('validation_expiration')->nullable();
                $table->timestamps();
            });
            
            // Seed some dummy data so the UI doesn't break
            DB::table('devices')->insert([
                ['id_box' => 'BOX-001', 'is_validated' => true, 'validation_expiration' => now()->addYear()->toDateString(), 'created_at' => now(), 'updated_at' => now()],
                ['id_box' => 'BOX-002', 'is_validated' => false, 'validation_expiration' => now()->subDays(10)->toDateString(), 'created_at' => now(), 'updated_at' => now()],
                ['id_box' => 'BOX-003', 'is_validated' => true, 'validation_expiration' => now()->addYear()->toDateString(), 'created_at' => now(), 'updated_at' => now()],
            ]);
        } else {
            Schema::table('devices', function (Blueprint $table) {
                if (!Schema::hasColumn('devices', 'is_validated')) {
                    $table->boolean('is_validated')->default(true);
                }
                if (!Schema::hasColumn('devices', 'validation_expiration')) {
                    $table->date('validation_expiration')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('devices')) {
            // Because we don't know if it originally existed, we can just drop the columns
            Schema::table('devices', function (Blueprint $table) {
                $table->dropColumn(['is_validated', 'validation_expiration']);
            });
        }
    }
};
