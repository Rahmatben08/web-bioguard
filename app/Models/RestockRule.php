<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestockRule extends Model
{
    protected $table = 'restock_rules';
    protected $primaryKey = 'id_rule';
    protected $guarded = [];
