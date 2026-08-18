<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Model PerjalananRute - Merepresentasikan satu sesi perjalanan kurir.
 *
 * @property int $id_rute
 * @property int $id_kurir
 * @property string $id_box
 * @property string $lokasi_tujuan
 * @property string $status_perjalanan
 */
class PerjalananRute extends Model
{
    use HasFactory;

    protected $table = 'perjalanan_rute';
    protected $primaryKey = 'id_rute';

    protected $fillable = [
        'id_kurir',
        'id_box',
        'nama_kargo',
        'lokasi_tujuan',
        'status_perjalanan',
    ];

    /**
     * Relasi: Perjalanan ini dimiliki oleh satu kurir.
     */
    public function kurir(): BelongsTo
    {
        return $this->belongsTo(Kurir::class, 'id_kurir', 'id_kurir');
    }

    /**
     * Relasi: Perjalanan ini memiliki banyak log telemetri.
     */
    public function logTelemetri(): HasMany
    {
        return $this->hasMany(LogTelemetri::class, 'id_rute', 'id_rute');
    }

    /**
     * Relasi: Ambil log telemetri TERBARU berdasarkan timestamp.
     * Menggunakan latestOfMany() untuk efisiensi query.
     * Digunakan untuk menampilkan suhu aktual & koordinat GPS paling mutakhir.
     */
    public function latestLog(): HasOne
    {
        return $this->hasOne(LogTelemetri::class, 'id_rute', 'id_rute')
                    ->where('is_outlier', false)
                    ->latestOfMany('timestamp');
    }

    /**
     * Scope: Hanya perjalanan yang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('status_perjalanan', 'aktif');
    }

    /**
     * Helper: Cek apakah suhu terakhir dalam rentang aman (2°C - 8°C).
     */
    public function isSuhuAman(): bool
    {
        if (!$this->latestLog) {
            return true; // No data yet, assume safe
        }
        $suhu = $this->latestLog->suhu_aktual;
        return $suhu >= 2.0 && $suhu <= 8.0;
    }

    /**
     * Menghitung durasi anomali suhu (ekskursi) dan menentukan status kelayakan obat termolabil.
     */
    public function getExcursionInfo(): array
    {
        $latestLog = $this->latestLog;
        if (!$latestLog) {
            return [
                'duration' => 0,
                'status' => 'Aman',
                'status_label' => 'Aman (Sesuai Standar 2°C - 8°C)',
                'badge_class' => 'bg-primary/10 text-primary border border-primary/30',
                'text_class' => 'text-cyan-500 font-bold',
                'border_class' => 'border-l-4 border-cyan-500 bg-surface-container transition-all duration-300 hover:-translate-y-1 hover:shadow-lg',
            ];
        }

        $temp = (float) $latestLog->suhu_aktual;
        $isOut = $temp < 2.0 || $temp > 8.0;

        if (!$isOut) {
            return [
                'duration' => 0,
                'status' => 'Aman',
                'status_label' => 'Aman (Sesuai Standar 2°C - 8°C)',
                'badge_class' => 'bg-primary/10 text-primary border border-primary/30',
                'text_class' => 'text-cyan-500 font-bold',
                'border_class' => 'border-l-4 border-cyan-500 bg-surface-container transition-all duration-300 hover:-translate-y-1 hover:shadow-lg',
            ];
        }

        // Fetch logs descending to find when the excursion started (longest contiguous sequence of out-of-bounds logs)
        $logs = $this->logTelemetri()->orderBy('timestamp', 'desc')->get();
        $firstOutLog = $latestLog;

        foreach ($logs as $log) {
            $t = (float) $log->suhu_aktual;
            if ($t < 2.0 || $t > 8.0) {
                $firstOutLog = $log;
            } else {
                break;
            }
        }

        $duration = ($latestLog->timestamp && $firstOutLog->timestamp)
            ? abs($latestLog->timestamp->diffInSeconds($firstOutLog->timestamp))
            : 0;

        if ($duration <= 30) {
            return [
                'duration' => $duration,
                'status' => 'Peringatan',
                'status_label' => 'Peringatan Dini (Anomali <= 30 detik)',
                'badge_class' => 'bg-tertiary/20 text-tertiary border border-tertiary/50 animate-pulse',
                'text_class' => 'text-amber-500 font-bold',
                'border_class' => 'border-l-4 border-amber-500 bg-amber-50 dark:bg-amber-900/20 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg',
            ];
        }

        return [
            'duration' => $duration,
            'status' => 'Tidak Layak Pakai',
            'status_label' => 'Tidak Layak Pakai (> 30 detik)',
            'badge_class' => 'bg-error/20 text-error border border-error/50 animate-pulse',
            'text_class' => 'text-red-500 font-bold',
            'border_class' => 'border-l-4 border-red-500 bg-red-50 dark:bg-red-900/20 ring-2 ring-red-500/30 animate-pulse transition-all duration-300 hover:-translate-y-1 hover:shadow-lg',
        ];
    }

    /**
     * Helper: Mendapatkan status kesehatan boks IoT (Baterai, Sinyal, Kalibrasi).
     */
    public function getDeviceHealth(): array
    {
        $boxId = $this->id_box;
        
        $battery = 92;
        $signal = -65;
        $calibration = 'Terkalibrasi';
        
        if ($boxId === 'BOX-002') {
            $battery = 85;
            $signal = -78;
            $calibration = 'Terkalibrasi';
        } elseif ($boxId === 'BOX-003') {
            $battery = 12; 
            $signal = -102;
            $calibration = 'Deviasi (Butuh Kalibrasi)';
        } else {
            $battery = 92;
            $signal = -63;
            $calibration = 'Terkalibrasi';
        }
        
        return [
            'battery' => $battery,
            'signal' => $signal,
            'calibration' => $calibration,
        ];
    }

    /**
     * Cek apakah rute ini memiliki status dialihkan/rerouted.
     */
    public function isRerouted(): bool
    {
        return \App\Models\IncidentLog::where('id_rute', $this->id_rute)
            ->where('jenis_insiden', 'Peringatan Dini')
            ->where('status', 'resolved')
            ->exists();
    }
}
