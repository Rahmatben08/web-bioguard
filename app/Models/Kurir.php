<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Kurir - Merepresentasikan data kurir pengantar.
 *
 * @property int $id_kurir
 * @property string $nama_lengkap
 * @property string $nomor_kendaraan
 */
class Kurir extends Model
{
    use HasFactory;

    protected $table = 'kurir';
    protected $primaryKey = 'id_kurir';

    protected $fillable = [
        'nama_lengkap',
        'nomor_kendaraan',
        'no_wa',
    ];

    /**
     * Relasi: Satu kurir memiliki banyak perjalanan rute.
     */
    public function perjalananRute(): HasMany
    {
        return $this->hasMany(PerjalananRute::class, 'id_kurir', 'id_kurir');
    }

    /**
     * Scope: Hanya kurir yang memiliki perjalanan aktif.
     */
    public function scopeAktif($query)
    {
        return $query->whereHas('perjalananRute', function ($q) {
            $q->where('status_perjalanan', 'aktif');
        });
    }

    /**
     * Relasi: Satu kurir bisa memiliki satu akun pengguna (User)
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id_kurir', 'id_kurir');
    }
}
