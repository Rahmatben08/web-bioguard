<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PredictionService
{
    /**
     * Memprediksi probabilitas kerusakan menggunakan bobot model SGDRegressor yang telah dilatih.
     * 
     * @param float $sisaJarakKm
     * @param float $durasiKemacetanMenit
     * @param float $fluktuasiMkt (selisih antara MKT saat ini dengan ambang batas 8.0)
     * @return array [ 'probabilitas_rusak' => float (0-100), 'instruksi_mitigasi' => string ]
     */
    public function predictRisk(float $sisaJarakKm, float $durasiKemacetanMenit, float $fluktuasiMkt): array
    {
        $weights = $this->loadModelWeights();

        // 1. Hitung persamaan regresi linier
        $z = ($weights['koef_sisa_jarak'] * $sisaJarakKm) + 
             ($weights['koef_kemacetan'] * $durasiKemacetanMenit) + 
             ($weights['koef_fluktuasi_mkt'] * max(0, $fluktuasiMkt)) + 
             $weights['intercept'];

        // SGDRegressor kita melatih data yang probabilitasnya adalah float 0-1
        $probabilitas = max(0, min(1, $z)); // clamp between 0 and 1
        $probabilitasPersen = $probabilitas * 100;
        
        // 2. Tentukan Instruksi Mitigasi Berdasarkan Probabilitas
        $instruksi = 'Suhu optimal. Pertahankan kondisi saat ini.';
        if ($probabilitasPersen > 70) {
            $instruksi = 'Segera cari lokasi pendingin terdekat, risiko kerusakan sangat tinggi!';
        } elseif ($probabilitasPersen > 30) {
            $instruksi = 'Peringatan dini: Periksa insulasi boks pendingin atau percepat pengiriman.';
        }

        return [
            'probabilitas_rusak' => round($probabilitasPersen, 2),
            'instruksi_mitigasi' => $instruksi
        ];
    }

    /**
     * Memuat bobot dari file ml/model_weights.json. Hasilnya di-cache agar tidak membaca file terus menerus.
     */
    private function loadModelWeights(): array
    {
        return Cache::remember('ml_model_weights', 3600, function () {
            $path = base_path('ml/model_weights.json');
            
            if (!file_exists($path)) {
                Log::warning('Model weights not found. Using default heuristic weights.');
                return [
                    'koef_sisa_jarak' => 0.0001,
                    'koef_kemacetan' => 0.0002,
                    'koef_fluktuasi_mkt' => 0.015,
                    'intercept' => 0.02
                ];
            }

            $json = file_get_contents($path);
            return json_decode($json, true);
        });
    }

    /**
     * Helper MVP: Hardcode estimasi jarak sisa dari titik kumpul awal (Dinkes Palembang)
     * ke lokasi tujuan spesifik (karena tabel perjalanan_rute belum menyimpan dest_latitude/longitude).
     * 
     * @param string $tujuan
     * @return float Jarak statis awal dalam KM 
     */
    public function getEstimatedRemainingDistance(string $tujuan, float $currentLat, float $currentLng): float
    {
        $destinations = [
            'RSUP Dr. Mohammad Hoesin' => ['lat' => -2.9666, 'lng' => 104.7505],
            'RSUD Palembang BARI' => ['lat' => -3.0185, 'lng' => 104.7645],
            'RS Charitas' => ['lat' => -2.9772, 'lng' => 104.7522],
            'Puskesmas Dempo' => ['lat' => -2.9865, 'lng' => 104.7630],
        ];

        if (array_key_exists($tujuan, $destinations)) {
            $destLat = $destinations[$tujuan]['lat'];
            $destLng = $destinations[$tujuan]['lng'];
            return $this->haversineDistance($currentLat, $currentLng, $destLat, $destLng);
        }

        return 0.0;
    }

    /**
     * Menghitung jarak antara 2 koordinat (Haversine formula) dalam Kilometer
     */
    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        
        return $earthRadius * $c;
    }
}
