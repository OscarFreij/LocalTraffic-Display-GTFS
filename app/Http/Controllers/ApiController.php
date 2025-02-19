<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stop;
use App\Models\Screen;
use App\Models\StopTime;
use App\Models\Trip;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\WorkerDataRetrievals;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ApiController extends Controller
{
    function Display(Request $request, String $screen_uuid)
    {
        $scale = $request->get('scale', 1);

        $screen = Screen::where('short_name', '=', $screen_uuid)->first();
        if (is_null($screen))
        {
            abort(404, "Screen with UUID: ".$screen_uuid." dose not exist");
        }
        else if (!$screen->enabled)
        {
            abort(403, "Screen with UUID: ".$screen_uuid." is disabled");
        }
        else
        {
            return view('screens.display.1x1', [
                'screen' => $screen,
                'scale' => $scale
            ]);
        }
    }

    function Data(Request $request, String $screen_uuid)
    {
        $screen = Screen::where('short_name', '=', $screen_uuid)->first();
        if (is_null($screen))
        {
            abort(404, "Screen with UUID: ".$screen_uuid." dose not exist");
        }
        else if (!$screen->enabled)
        {
            abort(403, "Screen with UUID: ".$screen_uuid." is disabled");
        }
        else
        {
            return ['screen' => $screen];
        }
    }

    function GetDepartures(Request $request, Int $stop_id)
    {
        $stop = Stop::Find($stop_id);
        $wdr = WorkerDataRetrievals::where('type', '=', '1')->orderBy('timestamp', 'desc')->first();

        // Add minutes to now
        $nowPlusMinutes = Carbon::now()->addMinutes((int)$request->get('stop_travle_time', 0));

        // Create a Carbon instance for 00:00:00 of the target date
        $targetDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $wdr->timestamp);

        $targetDateTime->hour = 0;
        $targetDateTime->minute = 0;
        $targetDateTime->second = 0;

        // Calculate the difference
        $diffInSeconds = $nowPlusMinutes->diffInSeconds($targetDateTime, false); // `false` keeps the sign

        $totalSeconds = abs($diffInSeconds);
        $hours = intdiv($totalSeconds, 3600); // Get the total hours
        $minutes = intdiv($totalSeconds % 3600, 60); // Get the remaining minutes
        $seconds = $totalSeconds % 60; // Get the remaining seconds

        // Format as HH:MM:SS
        $diffAsTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        //dd($wdr->timestamp);
        $departures = [];

        if ($stop->location_type == 0)
        {
            $stop_times = $stop
            ->stopTimes()
            ->where(function($query) use($diffAsTime) {
                    $query
                    ->where('departure_time', '>=', $diffAsTime)
                    ->orWhere('rt_departure_time', '>=', $diffAsTime);
                })
            ->orderBy('departure_time', 'asc')
            ->with('trip')
            ->whereHas('trip.calendar.calendarDates', function($query) use($targetDateTime) {
                $query->where('date', '=', $targetDateTime->format('Y-m-d'))->where('exception_type', '!=', '2');
            })
            ->take(12)->with('trip.route:route_id,route_short_name')->get();

            foreach ($stop_times as $stop_time) {
                $stop_time->status = $stop_time->status();
            }

            array_push($departures, ['stop' => $stop, 'stop_times' => $stop_times]);
        }
        else if ($stop->location_type == 1)
        {
            $stops = $stop->childStations()->where('location_type', '=', '0')->get();

            foreach ($stops as $subStop) {
                $subStop_times = $subStop
            ->stopTimes()
            ->where(function($query) use($diffAsTime) {
                    $query
                    ->where('departure_time', '>=', $diffAsTime)
                    ->orWhere('rt_departure_time', '>=', $diffAsTime);
                })
            ->orderBy('departure_time', 'asc')
            ->with('trip')
            ->whereHas('trip.calendar.calendarDates', function($query) use($targetDateTime) {
                $query->where('date', '=', $targetDateTime->format('Y-m-d'))->where('exception_type', '!=', '2');
            })
            ->take(12)->with('trip.route:route_id,route_short_name')->get();

            foreach ($subStop_times as $stop_time) {
                $stop_time->status = $stop_time->status();
            }

            array_push($departures, ['stop' => $subStop, 'stop_times' => $subStop_times]);
            }
        }

        return ['departures' => $departures];
    }

    function GetLatestStaticUpdateTimestamp(Request $request)
    {
        $wdr = WorkerDataRetrievals::where('type', '=', '1')->orderBy('timestamp', 'desc')->first();
        return ['timestamp' => $wdr->timestamp];
    }
    

    function GetLatestServiceAlertUpdateTimestamp(Request $request)
    {
        $wdr = WorkerDataRetrievals::where('type', '=', '2')->orderBy('timestamp', 'desc')->first();
        return ['timestamp' => $wdr->timestamp];
    }

    function GetLatestTripUpdateTimestamp(Request $request)
    {
        $wdr = WorkerDataRetrievals::where('type', '=', '3')->orderBy('timestamp', 'desc')->first();
        return ['timestamp' => $wdr->timestamp];
    }
}