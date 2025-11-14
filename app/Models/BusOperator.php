<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BusSchedule;

class BusOperator extends Model
{
    protected $fillable = [
        'name',
        'address',
        'contact_number',
        'email_address'
    ];

    public function busDetails() {
        return $this->hasMany(BusSchedule::class);
    }

}
