<?php

namespace App\Http\Controllers;

use App\Models\BusScheduleBooking;
use Illuminate\Http\Request;

class BusScheduleBookingController extends Controller
{

    public function index(Request $request) {

    }

    public function store(Request $request) {

        $attributes = $request->validate([
            '*.seat_number' => 'required|numeric|min:1',
            '*.bus_schedule_id' => 'required|integer|exists:bus_schedules,id',
            '*.fullname' => 'required|string|max:255',
            '*.age' => 'required|integer|min:0',
            '*.gender' => 'required|in:M,F',
            '*.email_address' => 'required|email',
        ]);

        $booking = [];

        foreach ($attributes as $item) {
            $booking[] = BusScheduleBooking::create($item);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bus Schedule booking created successfully',
            'data'    => $booking,
        ], 201);
    }

    public function getBusScheduleBookingByScheduleId($id) {
        $booking = BusScheduleBooking::select('seat_number', 'fullname', 'age', 'gender')
        ->where('bus_schedule_id', $id)
        ->get();
        return $booking;
    }

}
