<?php

namespace App\Http\Controllers;

use App\Models\BusDetail;
use Illuminate\Http\Request;

class BusDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buses = BusDetail::with(relations: ['bus:id,name', 'busOperator:id,name'])
        ->get(['id', 'bus_operator_id', 'bus_id', 'description', 'seat_capacity'])
        ->map( function ($busDetail) {
            return [
                'id' => $busDetail->id,
                'bus_operator_id' => $busDetail->bus_operator_id,
                'operator_name' => $busDetail->busOperator->name,
                'bus_id' => $busDetail->bus_id,
                'bus_name' => $busDetail->bus->name,
                'description' => $busDetail->description,
                'bus_full_description' => $busDetail->bus_full_description,
                'seat_capacity' => $busDetail->seat_capacity,
            ];
        });
        return $buses;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BusDetail $busDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusDetail $busDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusDetail $busDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusDetail $busDetail)
    {
        //
    }

    public function getBuses() {
        $buses = BusDetail::with(relations: ['bus:id,name', 'busOperator:id,name'])
        ->get(['id','bus_operator_id', 'description', 'bus_id','seat_capacity'])
        ->map( function ($busDetail) {
            return [
                'id' => $busDetail->id,
                'operator_name' => $busDetail->busOperator->name,
                'bus_name' => $busDetail->bus->name,
                'bus_full_description' => $busDetail->bus_full_description,
                'seat_capacity' => $busDetail->seat_capacity,
            ];
        });
        return $buses;
    }
}
