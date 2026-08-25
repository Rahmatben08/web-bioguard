<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchTransfer extends Model
{
    protected $table = 'batch_transfers';
    protected $primaryKey = 'id_transfer';
    protected $guarded = [];
}
