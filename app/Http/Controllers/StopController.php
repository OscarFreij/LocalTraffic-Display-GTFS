<?php

namespace App\Http\Controllers;

use App\Models\Stop;
use App\Models\Route;
use App\Models\Stop_time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if($request->filled('q'))
        {
            $stops = Stop::search($request->q)->simplePaginate(50);
        }
        else
        {
            $stops = Stop::orderBy('stop_name')->simplePaginate(20);
        }

        return view('stop.index' , [
            'stops' => $stops
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $stop = Stop::where('stop_id', '=', $id)->firstOrFail();
        $routesRAW = DB::table('stop_times')->distinct()->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('routes', 'routes.route_id', '=', 'trips.route_id')->select(['routes.*','stop_times.stop_headsign'])->where('stop_times.stop_id','=', $id)->get();
        $routes = Route::hydrate($routesRAW->toArray());

        $stop_times = $stop->stop_time()->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')->where('calendar_dates.date', '=', date('Ymd'))->orderBy('departure_time')->simplePaginate(5);
        
        return view('stop.show' , [
            'stop' => $stop,
            'routes' => $routes,
            'stop_times' => $stop_times
        ]);
    }
}
