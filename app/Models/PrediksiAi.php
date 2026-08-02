<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model PrediksiAi - Hasil evaluasi ML model untuk kelayakan obat termolabil.
 *
 * @property int $id_prediksi
 * @property int $id_log
 * @property float $probabilitas_rusak
 * @property string|null $rekomendasi_tindakan
 */
class PrediksiAi extends Model
{
    use HasFactory;

    protected $table = 'prediksi_ai';
    protected $primaryKey = 'id_prediksi';

    protected $fillable = [
        'id_log',
        'probabilitas_rusak',
        'rekomendasi_tindakan',
    ];

    protected $casts = [
        'probabilitas_rusak' => 'float',
    ];

    /**
     * Relasi: Prediksi AI merujuk pada satu log telemetri tertentu.
     */
    public function logTelemetri(): BelongsTo
    {
        return $this->belongsTo(LogTelemetri::class, 'id_log', 'id_log');
    }
}
