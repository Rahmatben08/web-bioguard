<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder demo dihapus dari pemanggilan otomatis agar tidak me-reset password admin
        // saat deploy/migrate production.
        // Untuk menggunakan di lokal, jalankan manual: php artisan db:seed --class=DemoSeeder
        // $this->call(DemoSeeder::class);
    }
}
