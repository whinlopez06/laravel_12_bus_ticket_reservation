<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorBus extends Model
{
    protected $fillable = [
        'bus_operator_id',
        'bus_detail_id'
    ];
}
