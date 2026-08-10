<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarkDemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tandai semua perjalanan rute yang terhubung ke BOX-00% sebagai data demo
        $updatedRows = DB::table('perjalanan_rute')
            ->where('id_box', 'LIKE', 'BOX-00%')
            ->update(['is_demo' => true]);
            
        $this->command->info("Berhasil menandai {$updatedRows} rute dengan is_demo = true.");
    }
}
