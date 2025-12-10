<?php

namespace App\Http\Controllers;

use App\Models\BusDetail;
use App\Models\BusSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class BusScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
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
                    'bus_detail_id' => $schedule->BusDetail->id,
                    'bus_full_description' => $schedule->BusDetail->bus_full_description,
                    'operator' => $schedule->BusDetail->busOperator->name,
                    'from_bus_location' => $schedule->fromBusLocation->name ?? null,
                    'to_bus_location' => $schedule->toBusLocation->name ?? null,
                    'from_bus_location_id' => $schedule->fromBusLocation->id,
                    'to_bus_location_id' => $schedule->toBusLocation->id,
                    'departure_time' => $schedule->departure_time,
                    'arrival_time' => $schedule->arrival_time,
                    'schedule_date' => $schedule->schedule_date,
                    'seat_capacity' =>$schedule->BusDetail->seat_capacity ?? null,
                    'price' => $schedule->BusDetail->price ?? null
                ];
            });

            return $busSchedules;

        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
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
        try {
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

        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

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
        try {
            $travelDate = (is_null($request->travel_date) || $request->travel_date === 'null') ? null : $request->travel_date;

            $busSchedules = BusSchedule::query()
                ->with([
                    'busDetail:id,bus_id,description,seat_capacity,price',
                    'busDetail.bus:id,name',
                    'fromLocation:id,name',
                    'toLocation:id,name',
                ])
                ->when($request->from_location_id, fn($q, $id) =>
                    $q->where('from_location_id', $id)
                )
                ->when($request->to_location_id, fn($q, $id) =>
                    $q->where('to_location_id', $id)
                )
                ->when($travelDate, fn($q, $date) =>
                    $q->whereDate('travel_date', $date)
                )
                ->get([
                    'id',
                    'bus_detail_id',
                    'from_location_id',
                    'to_location_id',
                    'boarding_time',
                    'travel_date',
                ])
                ->map(function ($schedule) {
                    $detail = $schedule->busDetail;

                    return [
                        'id'            => $schedule->id,
                        'bus_name'      => $detail->bus->name ?? null,
                        'description'   => $detail->description ?? null,
                        'from_location' => $schedule->fromLocation->name ?? null,
                        'to_location'   => $schedule->toLocation->name ?? null,
                        'boarding_time' => $schedule->boarding_time,
                        'travel_date'   => $schedule->travel_date,
                        'seat_capacity' => $detail->seat_capacity ?? null,
                        'price'         => $detail->price ?? null,
                    ];
                });

            return $busSchedules;

        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getBusScheduleById(Request $request, $id)
    {
        try {
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
                    'bus_detail_id' => $schedule->BusDetail->id,
                    'bus_id' => $schedule->busDetail->bus->id,
                    'bus_name' => $schedule->busDetail->bus->name,
                    'description' => $schedule->busDetail->description ?? null,
                    'from_bus_location' => $schedule->fromBusLocation->name,
                    'to_bus_location' => $schedule->toBusLocation->name,
                    'from_bus_location_id' => $schedule->fromBusLocation->id,
                    'to_bus_location_id' => $schedule->toBusLocation->id,
                    'departure_time' => $schedule->departure_time ?? null,
                    'arrival_time' => $schedule->arrival_time ?? null,
                    'schedule_date' => $schedule->schedule_date,
                    'seat_capacity' =>$schedule->BusDetail->seat_capacity ?? null,
                    'price' => $schedule->BusDetail->price ?? null
                ];
            });

            return $busSchedules[0];

        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getBusScheduleSummary()
    {
        try {
            $busSchedules = BusSchedule::query()
                ->join('bus_details', 'bus_schedules.bus_detail_id', '=', 'bus_details.id')
                ->join('buses', 'bus_details.bus_id', '=', 'buses.id')
                ->join('locations as locations_from', 'bus_schedules.from_location_id', '=', 'locations_from.id')
                ->join('locations as locations_to', 'bus_schedules.to_location_id', '=', 'locations_to.id')
                ->select(
                    'locations_from.id as from_location_id',
                    'locations_to.id as to_location_id',
                    'locations_from.name as from_location',
                    'locations_to.name as to_location',
                    'bus_schedules.travel_date',
                    DB::raw('COUNT(*) as bus_count')
                )
                ->groupBy(
                    'locations_from.id',
                    'locations_to.id',
                    'locations_from.name',
                    'locations_to.name',
                    'bus_schedules.travel_date'
                )
                ->orderBy(
                    'locations_from.name', 'asc'
                )
                ->get();

            return $busSchedules;

        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


}
