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
        // Seeder demo dipanggil secara otomatis agar tidak me-reset password admin menjadi kosong
        // saat deploy/migrate production, sangat penting untuk MVP.
        $this->call(DemoSeeder::class);
    }
}
