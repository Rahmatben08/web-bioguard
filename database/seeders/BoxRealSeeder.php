<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class BoxRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        // 1. Cek apakah BOX-1 sudah ada di tabel perjalanan_rute
        $boxExists = DB::table('perjalanan_rute')->where('id_box', 'BOX-1')->exists();

        if ($boxExists) {
            $this->command->info('BOX-1 sudah terdaftar. Melewati proses seeder (idempotent).');
            return;
        }

        // 2. Buat Kurir Uji Perangkat Asli
        $idKurir = DB::table('kurir')->insertGetId([
            'nama_lengkap' => 'Kurir Uji Perangkat Asli',
            'nomor_kendaraan' => 'BG-TEST', // Sengaja formatnya jelas terlihat testing
            'no_wa' => '081200000000',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Buat User untuk Kurir tersebut supaya bisa login
        DB::table('users')->insert([
            'name' => 'Kurir Uji Perangkat Asli',
            'email' => 'kurir_uji@bioguard.id',
            'password' => Hash::make('password'), // password standard
            'role' => 'kurir',
            'id_kurir' => $idKurir,
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4. Buat Perjalanan Rute yang aktif untuk BOX-1
        DB::table('perjalanan_rute')->insert([
            'id_kurir' => $idKurir,
            'id_box' => 'BOX-1',
            'nama_kargo' => 'Vaksin Uji Coba Hardware',
            'lokasi_tujuan' => 'Faskes Dummy untuk Testing Asli',
            'status_perjalanan' => 'aktif',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->command->info('Berhasil mendaftarkan BOX-1 dan Kurir Uji Perangkat Asli.');
    }
}
