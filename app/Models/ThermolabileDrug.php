<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model ThermolabileDrug - Data inventaris obat termolabil (insulin, vaksin, dll).
 *
 * @property int $id
 * @property string $no_batch
 * @property string $nama_produk
 * @property string $jenis
 * @property int $stok
 * @property float $suhu_penyimpanan
 * @property string $tanggal_kadaluwarsa
 * @property string $status
 */
class ThermolabileDrug extends Model
{
    use HasFactory;

    protected $table = 'thermolabile_drugs';

    protected $fillable = [
        'no_batch',
        'nama_produk',
        'jenis',
        'stok',
        'suhu_penyimpanan',
        'tanggal_kadaluwarsa',
        'status',
    ];

    protected $casts = [
        'stok' => 'integer',
        'suhu_penyimpanan' => 'float',
        'tanggal_kadaluwarsa' => 'date',
    ];
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class, 'id_batch', 'no_batch')->orderBy('waktu_transaksi', 'desc');
    }
}
