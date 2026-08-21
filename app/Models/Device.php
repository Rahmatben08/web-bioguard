<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_box',
        'is_validated',
        'validation_expiration',
    ];
    
    protected $casts = [
        'is_validated' => 'boolean',
        'validation_expiration' => 'date',
    ];
}
