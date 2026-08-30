<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InventoryHub;
use Illuminate\Support\Facades\Http;

class GeocodeFaskesCommand extends Command
{
    protected $signature = 'faskes:geocode';
    protected $description = 'Mengisi latitude dan longitude Faskes menggunakan OpenStreetMap Nominatim API';

    public function handle()
    {
        $hubs = InventoryHub::all();
        $this->info("Memulai geocoding untuk {$hubs->count()} Faskes di Palembang...");

        $client = new \GuzzleHttp\Client();

        foreach ($hubs as $hub) {
            // Jika sudah ada koordinatnya, skip (kecuali kalau mau dipaksa ulang)
            if ($hub->latitude != null && $hub->longitude != null) {
                $this->line("Skipping {$hub->nama} (Sudah ada koordinat)");
                continue;
            }

            // Keyword pencarian: Nama Faskes + Palembang
            $query = $hub->nama . ", Palembang";
            
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'BioGuard-PKMKC/1.0 (Student Project)'
                ])->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $query,
                    'format' => 'json',
                    'limit' => 1
                ]);

                if ($response->successful() && count($response->json()) > 0) {
                    $data = $response->json()[0];
                    $hub->latitude = $data['lat'];
                    $hub->longitude = $data['lon'];
                    $hub->save();

                    $this->info("V Sukses: {$hub->nama} -> {$data['lat']}, {$data['lon']}");
                } else {
                    // Coba tanpa "Puskesmas" atau "RS" jika pencarian pertama gagal
                    $cleanName = str_replace(['RSUD ', 'RSUP ', 'RS ', 'Puskesmas '], '', $hub->nama);
                    $query2 = $cleanName . ", Palembang";
                    
                    $response2 = Http::withHeaders([
                        'User-Agent' => 'BioGuard-PKMKC/1.0 (Student Project)'
                    ])->get('https://nominatim.openstreetmap.org/search', [
                        'q' => $query2,
                        'format' => 'json',
                        'limit' => 1
                    ]);

                    if ($response2->successful() && count($response2->json()) > 0) {
                        $data = $response2->json()[0];
                        $hub->latitude = $data['lat'];
                        $hub->longitude = $data['lon'];
                        $hub->save();
                        $this->info("V Sukses (Pencarian Alternatif): {$hub->nama} -> {$data['lat']}, {$data['lon']}");
                    } else {
                        $this->error("X Gagal ditemukan: {$hub->nama}");
                    }
                }
                
                // Nominatim API mensyaratkan delay 1 detik antar request agar tidak diblokir
                sleep(1);

            } catch (\Exception $e) {
                $this->error("Error memproses {$hub->nama}: " . $e->getMessage());
            }
        }

        $this->info("Geocoding selesai!");
    }
}
