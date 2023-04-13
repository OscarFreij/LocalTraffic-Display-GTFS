<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stop;
use App\Models\Stop_time;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Models\WorkerDataRetrieval;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Query\Builder;

class StopDisplayColumnController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $source_download_data = WorkerDataRetrieval::hydrate(DB::table('workerDataRetrievals')->where('type', '=', '1')->orderByDesc('id')->limit(1)->get()->toArray());

        $timeP24 = (date('H')+24-1).":".(date('i:s'));
        $timeP0 = (date('H')-1).":".(date('i:s'));

        $masterStop = Stop::find($id);

        if ($masterStop->location_type == 0)
        {
            $stop_times_earlyNEW = DB::table('stop_times')
                ->where('stop_times.stop_id', '=', $id)
                ->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')
                ->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')
                ->where('calendar_dates.date', '=', date('Ymd'))
                ->where(function(Builder $query){
                    $timeP24 = (date('H')+24).":".(date('i:s'));
                    $query->where('departure_time', '>=', $timeP24)
                    ->orWhere('rt_departure_time', '>=', strtotime('+1 day', time()));
                })
                ->orderBy('departure_time')
                ->orderBy('rt_departure_time')
                ->take(8)
                ->get()
                ->toArray();

            $stop_times_lateNEW = DB::table('stop_times')
                ->where('stop_times.stop_id', '=', $id)
                ->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')
                ->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')
                ->where('calendar_dates.date', '=', date('Ymd'))
                ->where(function(Builder $query){
                    $timeP0 = (date('H')).":".(date('i:s'));
                    $query->where('departure_time', '>=', $timeP0)
                    ->orWhere('rt_departure_time', '>=', time());
                })
                ->orderBy('departure_time')
                ->orderBy('rt_departure_time')
                ->take(8)
                ->get()
                ->toArray();
            $stop_times_array = $stop_times_earlyNEW + $stop_times_lateNEW;
        }
        else if ($masterStop->location_type == 1)
        {
            $ids = array();
            $stops = DB::table('stops')->where('parent_station', '=', $masterStop->stop_id)->where('location_type', '=', 0)->get();
            foreach ($stops as $stop) {
                array_push($ids, $stop->stop_id);
            }
            $stop_times_earlyNEW = DB::table('stop_times')
                ->whereIn('stop_times.stop_id', $ids)
                ->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')
                ->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')
                ->where('calendar_dates.date', '=', date('Ymd'))
                ->where(function(Builder $query){
                    $timeP24 = (date('H')+24).":".(date('i:s'));
                    $query->where('departure_time', '>=', $timeP24)
                    ->orWhere('rt_departure_time', '>=', strtotime('+1 day', time()));
                })
                ->orderBy('departure_time')
                ->orderBy('rt_departure_time')
                ->take(8)
                ->get()
                ->toArray();
            $stop_times_lateNEW = DB::table('stop_times')
                ->whereIn('stop_times.stop_id',  $ids)
                ->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')
                ->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')
                ->where('calendar_dates.date', '=', date('Ymd'))
                ->where(function(Builder $query){
                    $timeP0 = (date('H')).":".(date('i:s'));
                    $query->where('departure_time', '>=', $timeP0)
                    ->orWhere('rt_departure_time', '>=', time());
                })
                ->orderBy('departure_time')
                ->orderBy('rt_departure_time')
                ->take(8)
                ->get()
                ->toArray();
            $stop_times_array = $stop_times_earlyNEW + $stop_times_lateNEW;
        }
        
        

        //$stop_times_early = $stop->stop_time()->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')->where('calendar_dates.date', '=', date('Ymd'))->where('departure_time', '>=', $timeP24)->orderBy('departure_time')->limit(8)->get()->toArray();
        //$stop_times_late = $stop->stop_time()->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')->where('calendar_dates.date', '=', date('Ymd'))->where('departure_time', '>=', date('H:i:s'))->orderBy('departure_time')->limit(8)->get()->toArray();

        $stop_times = Stop_time::hydrate($stop_times_array);
        return view('displayAPI.column' , [
            'master_stop_data' => $masterStop,
            'source_download_data' => $source_download_data[0],
            'stop_times' => $stop_times
        ]);
    }
}
