with open(r"app/Services/PredictionService.php", "r", encoding="utf-8") as f:
    content = f.read()

old_block = """    public function getEstimatedRemainingDistance(string $tujuan, float $currentLat, float $currentLng): float
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
    }"""

new_block = """    public function getEstimatedRemainingDistance(string $tujuan, float $currentLat, float $currentLng): float
    {
        $faskes = \App\Models\InventoryHub::where('nama', $tujuan)->first();
        if ($faskes && $faskes->latitude && $faskes->longitude) {
            return $this->haversineDistance($currentLat, $currentLng, (float) $faskes->latitude, (float) $faskes->longitude);
        }

        return 0.0; // Fallback jika faskes tidak ditemukan
    }"""

if old_block in content:
    content = content.replace(old_block, new_block)
    with open(r"app/Services/PredictionService.php", "w", encoding="utf-8") as f:
        f.write(content)
    print("Fixed PredictionService geofencing hardcode!")
else:
    print("Could not find the block in PredictionService.php")
