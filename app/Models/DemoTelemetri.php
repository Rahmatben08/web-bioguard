<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemoTelemetri extends Model
{
    protected $table = 'demo_telemetri';
    protected $primaryKey = 'id_log';
    public $timestamps = false;

    protected $fillable = [
        'id_rute',
        'timestamp',
        'suhu_aktual',
        'nilai_mkt',
        'latitude',
        'longitude',
        'is_synced_from_offline',
        'gaya_guncangan'
    ];
}
