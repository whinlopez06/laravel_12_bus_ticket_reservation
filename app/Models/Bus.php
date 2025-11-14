<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'name'
    ];

    public function busDetails() {
        return $this->hasMany(BusDetail::class);
    }
}
