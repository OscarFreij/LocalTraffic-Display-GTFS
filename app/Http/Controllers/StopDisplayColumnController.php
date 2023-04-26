<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stop;
use App\Models\Stop_time;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Models\WorkerDataRetrieval;
use DateTime;
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

        $selectionArray = ['stop_times.trip_id','stop_times.arrival_time','stop_times.rt_arrival_time','stop_times.departure_time','stop_times.rt_departure_time','stop_times.stop_id','stop_times.stop_headsign', 'stops.platform_code','trips.schedule_relationship as trip_schedule_relationship', 'stop_times.schedule_relationship as stop_time_schedule_relationship', 'trips.serviceAlertCancelled', 'trips.route_id', 'trips.service_id', 'trips.direction_id', 'calendar_dates.date'];

        if ($masterStop->location_type == 0)
        {
            $stop_times_earlyNEW = DB::table('stop_times')
                ->where('stop_times.stop_id', '=', $id)
                ->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')
                ->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')
                ->join('stops', 'stop_times.stop_id', '=', 'stops.stop_id')
                ->where('calendar_dates.date', '=', date('Ymd'))
                ->where(function(Builder $query){
                    $timeP24 = (date('H')+24).":".(date('i:s'));
                    $query->where('departure_time', '>=', $timeP24)
                    ->orWhere(function(Builder $query){
                        $dateTime = new DateTime();
                        $dateTime->modify("+1 day");
                        $query->where('rt_departure_time', '>=', $dateTime->format('Y-m-d H:i:s'))
                        ->whereNotNull('rt_departure_time');
                    });
                })
                ->orderByRaw('ifnull(rt_departure_time, departure_time)')
                ->select($selectionArray)
                ->take(8)
                ->get()
                ->toArray();

            $stop_times_lateNEW = DB::table('stop_times')
                ->where('stop_times.stop_id', '=', $id)
                ->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')
                ->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')
                ->join('stops', 'stop_times.stop_id', '=', 'stops.stop_id')
                ->where('calendar_dates.date', '=', date('Ymd'))
                ->where(function(Builder $query){
                    $timeP0 = (date('H')).":".(date('i:s'));
                    $query->where('departure_time', '>=', $timeP0)
                    ->orWhere(function(Builder $query){
                        $dateTime = new DateTime();
                        $query->where('rt_departure_time', '>=', $dateTime->format('Y-m-d H:i:s'))
                        ->whereNotNull('rt_departure_time');
                    });
                })
                ->orderByRaw('ifnull(rt_departure_time, departure_time)')
                ->select($selectionArray)
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
                ->join('stops', 'stop_times.stop_id', '=', 'stops.stop_id')
                ->where('calendar_dates.date', '=', date('Ymd'))
                ->where(function(Builder $query){
                    $timeP24 = (date('H')+24).":".(date('i:s'));
                    $query->where('departure_time', '>=', $timeP24)
                    ->orWhere(function(Builder $query){
                        $dateTime = new DateTime();
                        $dateTime->modify("+1 day");
                        $query->where('rt_departure_time', '>=', $dateTime->format('Y-m-d H:i:s'))
                        ->whereNotNull('rt_departure_time');
                    });
                })
                ->orderByRaw('ifnull(rt_departure_time, departure_time)')
                ->select($selectionArray)
                ->take(8)
                ->get()
                ->toArray();

            $stop_times_lateNEW = DB::table('stop_times')
                ->whereIn('stop_times.stop_id',  $ids)
                ->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')
                ->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')
                ->join('stops', 'stop_times.stop_id', '=', 'stops.stop_id')
                ->where('calendar_dates.date', '=', date('Ymd'))
                ->where(function(Builder $query){
                    $timeP0 = (date('H')).":".(date('i:s'));
                    $query->where('departure_time', '>=', $timeP0)
                    ->orWhere(function(Builder $query){
                        $dateTime = new DateTime();
                        $query->where('rt_departure_time', '>=', $dateTime->format('Y-m-d H:i:s'))
                        ->whereNotNull('rt_departure_time');
                    });
                })
                ->orderByRaw('ifnull(rt_departure_time, departure_time)')
                ->select($selectionArray)
                ->take(8)
                ->get()
                ->toArray();
            $stop_times_array = $stop_times_earlyNEW + $stop_times_lateNEW;
        }
        
        

        //$stop_times_early = $stop->stop_time()->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')->where('calendar_dates.date', '=', date('Ymd'))->where('departure_time', '>=', $timeP24)->orderBy('departure_time')->limit(8)->get()->toArray();
        //$stop_times_late = $stop->stop_time()->join('trips', 'trips.trip_id', '=', 'stop_times.trip_id')->join('calendar_dates', 'trips.service_id', '=', 'calendar_dates.service_id')->where('calendar_dates.date', '=', date('Ymd'))->where('departure_time', '>=', date('H:i:s'))->orderBy('departure_time')->limit(8)->get()->toArray();

        $stop_times = Stop_time::hydrate($stop_times_array);
        //dd($stop_times);
        return view('displayAPI.column' , [
            'master_stop_data' => $masterStop,
            'source_download_data' => $source_download_data[0],
            'stop_times' => $stop_times
        ]);
    }
}
