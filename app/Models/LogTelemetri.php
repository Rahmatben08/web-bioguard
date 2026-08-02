<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Model LogTelemetri - Data telemetri dari sensor IoT pada box obat termolabil.
 *
 * @property int $id_log
 * @property int $id_rute
 * @property string $timestamp
 * @property float $suhu_aktual
 * @property float|null $nilai_mkt
 * @property float $latitude
 * @property float $longitude
 * @property bool $is_synced_from_offline
 */
class LogTelemetri extends Model
{
    use HasFactory;

    protected $table = 'log_telemetri';
    protected $primaryKey = 'id_log';
    public $timestamps = false; // Uses custom 'timestamp' field

    protected $fillable = [
        'id_rute',
        'timestamp',
        'suhu_aktual',
        'nilai_mkt',
        'latitude',
        'longitude',
        'is_synced_from_offline',
        'gaya_guncangan',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'suhu_aktual' => 'decimal:2',
        'nilai_mkt' => 'decimal:2',
        'latitude' => 'double',
        'longitude' => 'double',
        'is_synced_from_offline' => 'boolean',
        'gaya_guncangan' => 'decimal:2',
    ];

    /**
     * Relasi: Log ini memiliki satu prediksi AI.
     */
    public function prediksiAi(): HasOne
    {
        return $this->hasOne(PrediksiAi::class, 'id_log', 'id_log');
    }

    /**
     * Relasi: Log ini milik satu perjalanan rute.
     */
    public function perjalananRute(): BelongsTo
    {
        return $this->belongsTo(PerjalananRute::class, 'id_rute', 'id_rute');
    }

    /**
     * Helper: Cek apakah suhu dalam rentang aman Cold Chain (2°C - 8°C).
     */
    public function isSuhuAman(): bool
    {
        return $this->suhu_aktual >= 2.0 && $this->suhu_aktual <= 8.0;
    }
}
