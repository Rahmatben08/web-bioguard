<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokAudit extends Model
{
    protected $table = 'stok_audits';
    protected $primaryKey = 'id_audit';
    protected $guarded = [];
