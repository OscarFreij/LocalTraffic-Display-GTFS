<?php

namespace App\Http\Controllers;

use App\Models\Stop;
use App\Models\Route;
use App\Models\Stop_time;
use App\Models\WorkerDataRetrieval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Array_;

class StopDisplayColumnController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $source_download_data = WorkerDataRetrieval::hydrate(DB::table('workerDataRetrievals')->where('type', '=', '1')->orderByDesc('id')->limit(1)->get()->toArray());

        //
        $stop = Stop::where('stop_id', '=', $id)->firstOrFail();

        $timeP24 = (date('H')+23).":".date('i:s');
        $timeP0 = date('H:i:s');
        //$routesRAW = DB::table('stop_times')->distinct()->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('routes', 'routes.route_id', '=', 'trips.route_id')->select(['routes.*','stop_times.stop_headsign'])->where('stop_times.stop_id','=', $id)->get();
        //$routes = Route::hydrate($routesRAW->toArray());
        $stop_times_earlyNEW = DB::table('stop_times')->where('stop_times.stop_id', '=', $id)->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')->where('calendar_dates.date', '=', date('Ymd'))->where('departure_time', '>=', $timeP24)->orderBy('departure_time')->limit(8)->get()->toArray();
        $stop_times_lateNEW = DB::table('stop_times')->where('stop_times.stop_id', '=', $id)->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')->where('calendar_dates.date', '=', date('Ymd'))->where('departure_time', '>=',$timeP0)->orderBy('departure_time')->limit(8)->get()->toArray();

        //$stop_times_early = $stop->stop_time()->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')->where('calendar_dates.date', '=', date('Ymd'))->where('departure_time', '>=', $timeP24)->orderBy('departure_time')->limit(8)->get()->toArray();
        //$stop_times_late = $stop->stop_time()->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')->where('calendar_dates.date', '=', date('Ymd'))->where('departure_time', '>=', date('H:i:s'))->orderBy('departure_time')->limit(8)->get()->toArray();

        $stop_times = Stop_time::hydrate($stop_times_earlyNEW + $stop_times_lateNEW);
        return view('displayAPI.column' , [
            'source_download_data' => $source_download_data[0],
            'stop_times' => $stop_times
        ]);
    }
}
