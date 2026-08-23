<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'quantity',
        'reference_batch',
        'reference_faskes',
        'route_id',
        'trigger_by',
        'trigger_user_id',
        'notes',
    ];

    /**
     * Memastikan kolom type valid
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $validTypes = ['in', 'out', 'adjustment'];
            if (!in_array($model->type, $validTypes)) {
                throw new \InvalidArgumentException("Invalid stock ledger type: {$model->type}");
            }
        });
    }

    /**
     * Relasi ke Batch Obat (Pusat)
     */
    public function batch()
    {
        return $this->belongsTo(ThermolabileDrug::class, 'reference_batch', 'no_batch');
    }

    /**
     * Relasi ke Faskes (Inventory Hub)
     */
    public function faskes()
    {
        return $this->belongsTo(InventoryHub::class, 'reference_faskes', 'id_faskes');
    }

    /**
     * Relasi ke Rute Perjalanan
     */
    public function route()
    {
        return $this->belongsTo(PerjalananRute::class, 'route_id', 'id_rute');
    }

    /**
     * Relasi ke User (Admin)
     */
    public function triggerUser()
    {
        return $this->belongsTo(User::class, 'trigger_user_id', 'id');
    }
}
