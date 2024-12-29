<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripsController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Int $trip_id, Request $request)
    {
        //
        $trip = Trip::findOrFail($trip_id);       
        return view('data.trips.show', [
            'trip' => $trip,
        ]);
    } 
}
