<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bus;
use App\Models\BusSchedule;

class BusDetail extends Model
{
    protected $fillable = [
        'bus_operator_id',
        'bus_id',
        'description',
        'plate_number',
        'seat_capacity',
        'price'
    ];

    public function busOperator() {
        return $this->belongsTo(BusOperator::class);
    }

    public function bus() {
        return $this->belongsTo(Bus::class);
    }

    public function busSchedules() {
        return $this->hasMany(BusSchedule::class);
    }

    public function getBusFullDescriptionAttribute() {
        return "{$this->bus->name} - {$this->description}";
    }

}
