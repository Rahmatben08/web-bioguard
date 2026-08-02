<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model IncidentLog - Log insiden ketika terjadi pelanggaran suhu rantai dingin.
 *
 * @property int $id
 * @property int $id_rute
 * @property string $jenis_insiden
 * @property string $deskripsi
 * @property float $suhu_tercatat
 * @property int $durasi_anomali
 * @property string $status
 */
class IncidentLog extends Model
{
    use HasFactory;

    protected $table = 'incident_logs';

    protected $fillable = [
        'id_rute',
        'jenis_insiden',
        'deskripsi',
        'suhu_tercatat',
        'durasi_anomali',
        'status',
    ];

    protected $casts = [
        'suhu_tercatat' => 'float',
        'durasi_anomali' => 'integer',
    ];

    /**
     * Relasi: Insiden terikat pada satu perjalanan rute tertentu.
     */
    public function perjalananRute(): BelongsTo
    {
        return $this->belongsTo(PerjalananRute::class, 'id_rute', 'id_rute');
    }
}
