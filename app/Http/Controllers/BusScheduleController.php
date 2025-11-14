<?php

namespace App\Http\Controllers;

use App\Models\BusDetail;
use App\Models\BusSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $busSchedules = BusSchedule::with(relations: [
            'busDetail' => function ($query) {
                $query->select('id','bus_id','description','seat_capacity','price');
            },
            'busDetail.bus:id,name',
            'busDetail.busOperator:id,name',
            'fromBusLocation:id,name',
            'toBusLocation:id,name',
        ])->get([
            'id',
            'bus_detail_id',
            'from_bus_location_id',
            'to_bus_location_id',
            'departure_time',
            'arrival_time',
            'schedule_date',
        ])->map(function ($schedule){
            return [
                'id' => $schedule->id,
                'bus_full_description' => $schedule->BusDetail->bus_full_description,
                'operator' => $schedule->BusDetail->busOperator->name,
                'from_bus_location' => $schedule->fromBusLocation->name ?? null,
                'to_bus_location' => $schedule->toBusLocation->name ?? null,
                'departure_time' => $schedule->departure_time,
                'arrival_time' => $schedule->arrival_time,
                'schedule_date' => $schedule->schedule_date,
                'seat_capacity' =>$schedule->BusDetail->seat_capacity ?? null,
                'price' => $schedule->BusDetail->price ?? null
            ];
        });

        return $busSchedules;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'bus_detail_id' => 'required',
            'from_bus_location_id' => 'required',
            'to_bus_location_id' => 'required',
            'departure_time' => 'nullable|date_format:H:i',
            'arrival_time' => 'nullable|date_format:H:i',
            'schedule_date' => 'required',
        ]);

        $busSchedule = BusSchedule::create($attributes);

        return response()->json([
            'success' => true,
            'message' => 'Bus Schedule created successfully',
            'data'    => $busSchedule,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BusSchedule $busSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusSchedule $busSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusSchedule $busSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusSchedule $busSchedule)
    {
        //
    }

    public function searchBusSchedule(Request $request)
    {
        if (is_null(value: $request->schedule_date) || $request->schedule_date === 'null') {
            $request->schedule_date = null;
        }
        $busSchedules = BusSchedule::with([
            'busDetail' => function ($query) {
                $query->select('id','bus_id','description','seat_capacity','price');
            },
            'busDetail.bus:id,name',
            'fromBusLocation:id,name',
            'toBusLocation:id,name',
        ])->when($request->from_bus_location_id, function($query, $fromId) {
            $query->where('from_bus_location_id', $fromId);
        })->when($request->to_bus_location_id, function($query, $toId) {
            $query->where('to_bus_location_id', $toId);
        })->when($request->schedule_date, function($query, $date){
            $query->whereDate('schedule_date', $date);
            //$query->whereDate('schedule_date', $date);
        })->get([
            'id',
            'bus_detail_id',
            'from_bus_location_id',
            'to_bus_location_id',
            'departure_time',
            'arrival_time',
            'schedule_date',
        ])->map(function ($schedule){
            return [
                'id' => $schedule->id,
                'bus_name' => $schedule->busDetail->bus->name ?? null,
                'description' => $schedule->busDetail->description ?? null,
                'from_bus_location' => $schedule->fromBusLocation->name ?? null,
                'to_bus_location' => $schedule->toBusLocation->name ?? null,
                'departure_time' => $schedule->departure_time,
                'arrival_time' => $schedule->arrival_time,
                'schedule_date' => $schedule->schedule_date,
                'seat_capacity' =>$schedule->BusDetail->seat_capacity ?? null,
                'price' => $schedule->BusDetail->price ?? null
            ];
        });

        return $busSchedules;
    }

    public function getBusScheduleById(Request $request, $id)
    {
        $busSchedules = BusSchedule::with([
        'busDetail' => function ($query) {
            $query->select('id','bus_id','description','seat_capacity','price');
        },
        'busDetail.bus:id,name',
        'fromBusLocation:id,name',
        'toBusLocation:id,name',
        ])->where('id', $id)
        ->get(columns: [
            'id',
            'bus_detail_id',
            'from_bus_location_id',
            'to_bus_location_id',
            'departure_time',
            'arrival_time',
            'schedule_date',
        ])->map(callback: function (BusSchedule $schedule){
            return [
                'id' => $schedule->id,
                'bus_name' => $schedule->busDetail->bus->name ?? null,
                'description' => $schedule->busDetail->description ?? null,
                'from_bus_location' => $schedule->fromBusLocation->name ?? null,
                'to_bus_location' => $schedule->toBusLocation->name ?? null,
                'departure_time' => $schedule->departure_time,
                'arrival_time' => $schedule->arrival_time,
                'schedule_date' => $schedule->schedule_date,
                'seat_capacity' =>$schedule->BusDetail->seat_capacity ?? null,
                'price' => $schedule->BusDetail->price ?? null
            ];
        });

        return $busSchedules;
    }

    public function getBusScheduleSummary() {
        $busSchedules = BusSchedule::query()
            ->join('bus_details', 'bus_schedules.bus_detail_id', '=', 'bus_details.id')
            ->join('buses', 'bus_details.bus_id', '=', 'buses.id')
            ->join('bus_locations as bus_locations_from', 'bus_schedules.from_bus_location_id', '=', 'bus_locations_from.id')
            ->join('bus_locations as bus_locations_to', 'bus_schedules.to_bus_location_id', '=', 'bus_locations_to.id')
            ->select(
                'buses.name as bus_name',
                'bus_locations_from.name as from_bus_location',
                'bus_locations_to.name as to_bus_location',
                'bus_schedules.departure_time',
                'bus_schedules.schedule_date',
                DB::raw('COUNT(*) as bus_count')
            )
            ->groupBy(
                'buses.name',
                'bus_locations_from.name',
                'bus_locations_to.name',
                'bus_schedules.departure_time',
                'bus_schedules.schedule_date'
            )
            ->get();
        return $busSchedules;
    }
}
