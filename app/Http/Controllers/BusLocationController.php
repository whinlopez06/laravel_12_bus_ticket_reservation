<?php

namespace App\Http\Controllers;

use App\Models\BusLocation;
use Illuminate\Http\Request;

class BusLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //return $busLocations = BusLocation::all();
         return BusLocation::select('id', 'name')->get();
         //$result = !empty($busLocations) ? $busLocations : [];
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
    public function show(BusLocation $busLocation)
    {
        return $busLocation = BusLocation::find(9);
        // return response()->json([$busLocation]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusLocation $busLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusLocation $busLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusLocation $busLocation)
    {
        //
    }

    // public function getBusLocations() {
    //    return BusLocation::all();
    // }
}
