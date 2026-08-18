<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PredictionService
{
    /**
     * Memprediksi probabilitas kerusakan memanggil API FastAPI model SGD.
     * Menggunakan try-catch agar tidak memutus flow utama telemetri jika API down.
     */
    public function predictRisk(float $sisaJarakKm, float $durasiKemacetanMenit, float $suhuSaatIni, float $mktSejauhIni): array
    {
        try {
            // Panggil API Python (FastAPI) dengan timeout singkat agar tidak nge-hang jika mati
            $response = \Illuminate\Support\Facades\Http::timeout(3)->post('http://127.0.0.1:8001/predict', [
                'jarak_tempuh_km' => $sisaJarakKm,
                'durasi_kemacetan_menit' => $durasiKemacetanMenit,
                'suhu_saat_ini' => $suhuSaatIni,
                'nilai_mkt_sejauh_ini' => $mktSejauhIni
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'probabilitas_rusak' => round($data['probabilitas_rusak'] * 100, 2), // DB expects 0-100 float
                    'instruksi_mitigasi' => $data['instruksi_mitigasi'] ?? 'Kondisi aman, lanjutkan perjalanan.'
                ];
            } else {
                Log::warning('API Prediksi AI merespons dengan error', ['status' => $response->status()]);
            }
        } catch (\Exception $e) {
            Log::warning('Gagal memanggil API Prediksi AI: ' . $e->getMessage());
        }

        // Fallback rule-based jika API gagal dipanggil (mencegah error 500)
        // Probabilitas null agar terdeteksi sebagai "Tidak Tersedia" di dashboard
        return [
            'probabilitas_rusak' => null,
            'instruksi_mitigasi' => 'Layanan AI Tidak Tersedia'
        ];
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
