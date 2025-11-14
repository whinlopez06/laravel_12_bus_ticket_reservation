<?php

namespace App\Models;
use App\Models\BusSchedule;

use Illuminate\Database\Eloquent\Model;

class BusScheduleBooking extends Model
{
    protected $fillable = [
        'bus_schedule_id',
        'seat_number',
        'fullname',
        'email_address',
        'age',
        'gender'
    ];

    public function busSchedules() {
        return $this->belongsTo(BusSchedule::class);
    }
}
