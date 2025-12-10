<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BusOperator;
use App\Models\BusDetail;
use App\Models\Location;
use App\Models\BusScheduleBooking;

class BusSchedule extends Model
{
    protected $fillable = [
        // 'bus_operator_id',
        'bus_detail_id',
        'from_bus_location_id',
        'to_bus_location_id',
        'departure_time',
        'arrival_time',
        'schedule_date',
    ];

    // public function busOperator() {
    //     return $this->belongsTo(BusOperator::class);
    // }

    public function busDetail() {
        return $this->belongsTo(BusDetail::class);
    }

    public function fromLocation() {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    public function toLocation() {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    public function busScheduleBooking() {
        return $this->hasMany(BusScheduleBooking::class);
    }
}
