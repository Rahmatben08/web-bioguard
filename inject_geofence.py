with open(r"app/Http/Controllers/Api/SyncController.php", "r", encoding="utf-8") as f:
    content = f.read()

old_block = """                if ($rute) {
                    $sisaJarak = $predictionService->getEstimatedRemainingDistance($rute->lokasi_tujuan, $log->latitude, $log->longitude);
                }"""

new_block = """                if ($rute) {
                    $sisaJarak = $predictionService->getEstimatedRemainingDistance($rute->lokasi_tujuan, $log->latitude, $log->longitude);
                    
                    // ==========================================
                    // GEOFENCING & DEVIATION LOGIC
                    // ==========================================
                    // 1. Arrival Geofencing (Radius 1km)
                    if ($sisaJarak > 0 && $sisaJarak <= 1.0) {
                        // Cek apakah sudah ada notifikasi kedatangan untuk rute ini
                        $alreadyArrived = \App\Models\IncidentLog::where('id_rute', $rute->id_rute)
                            ->where('jenis_insiden', 'Memasuki Radius Tujuan')
                            ->exists();
                            
                        if (!$alreadyArrived) {
                            \App\Models\IncidentLog::create([
                                'id_rute' => $rute->id_rute,
                                'jenis_insiden' => 'Memasuki Radius Tujuan',
                                'deskripsi' => "Kurir berada dalam radius 1km dari {$rute->lokasi_tujuan} (Jarak: " . round($sisaJarak, 1) . " km). Bersiap untuk serah terima.",
                                'suhu_tercatat' => $suhu,
                                'durasi_anomali' => 0,
                                'status' => 'resolved' // Otomatis resolved krn ini info positif
                            ]);
                        }
                    }
                    
                    // 2. Deviation Geofencing (Sisa Jarak bertambah secara ekstrim)
                    // (Sederhananya: jika sisa jarak lebih besar dari 15km, asumsikan deviasi rute ekstrim)
                    if ($sisaJarak > 15.0) {
                        $alreadyDeviated = \App\Models\IncidentLog::where('id_rute', $rute->id_rute)
                            ->where('jenis_insiden', 'Deviasi Rute')
                            ->where('status', 'active')
                            ->exists();
                            
                        if (!$alreadyDeviated) {
                            \App\Models\IncidentLog::create([
                                'id_rute' => $rute->id_rute,
                                'jenis_insiden' => 'Deviasi Rute',
                                'deskripsi' => "Terdeteksi deviasi rute yang jauh! Jarak dari tujuan ({$rute->lokasi_tujuan}) melebihi 15km (Jarak aktual: " . round($sisaJarak, 1) . " km).",
                                'suhu_tercatat' => $suhu,
                                'durasi_anomali' => 0,
                                'status' => 'active'
                            ]);
                        }
                    }
                }"""

if old_block in content:
    content = content.replace(old_block, new_block)
    with open(r"app/Http/Controllers/Api/SyncController.php", "w", encoding="utf-8") as f:
        f.write(content)
    print("Injected Geofencing Logic!")
else:
    print("Could not find block in SyncController.php")
