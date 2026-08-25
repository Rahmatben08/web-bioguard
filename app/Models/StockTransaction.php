<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;

    protected $table = 'stock_transactions';

    protected $fillable = [
        'id_batch',
        'tipe',
        'jumlah',
        'sumber_transaksi',
        'id_referensi',
        'waktu_transaksi',
        'dilakukan_oleh',
    ];

    public $timestamps = true;

    protected $casts = [
        'waktu_transaksi' => 'datetime',
    ];

    /**
     * Relasi ke Batch Obat (ThermolabileDrug)
     */
    public function batch()
    {
        return $this->belongsTo(ThermolabileDrug::class, 'id_batch', 'no_batch');
    }

    /**
     * Relasi ke User (Admin yang melakukan input, jika ada)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'dilakukan_oleh', 'id');
    }

    /**
     * Relasi opsional ke rute perjalanan (Jika sumber transaksi dari serah terima kurir)
     */
    public function rute()
    {
        return $this->belongsTo(PerjalananRute::class, 'id_referensi', 'id_rute');
    }
}
