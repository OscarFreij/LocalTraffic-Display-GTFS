<?php

namespace App\Models;

use DateTime;
use DateInterval;
use App\Models\Route;
use App\Models\Shape;
use App\Models\Calendar;
use App\Models\StopTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use Lacodix\LaravelModelFilter\Traits\IsSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
    /** @use HasFactory<\Database\Factories\TripFactory> */
    use HasFactory;

    protected $primaryKey = 'trip_id';


    function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }

    function stopTimes()
    {
        return $this->hasMany(StopTime::class, 'trip_id', 'trip_id');
    }

    function calendar()
    {
        return $this->belongsTo(Calendar::class, 'service_id', 'service_id');
    }

    function shape()
    {
        return $this->hasMany(Shape::class, 'shape_id', 'shape_id');
    }

    function statusAndTimes()
    {

        $stop_times_first = StopTime::where('trip_id', $this->trip_id)->where('stop_sequence', '=', 1)->first();
        //$stop_times_last = StopTime::whereIn('trip_id', $trips_paginated->pluck('trip_id'))->orderBy('trip_id', 'asc')->orderBy('stop_sequence', 'desc')->distinct('trip_id')->get();
        $stop_times_last = StopTime::where('trip_id', $this->trip_id)->orderBy('stop_sequence', 'desc')->first();

        $wdr = WorkerDataRetrievals::where('type', '=', '1')->orderBy('timestamp', 'desc')->first();

        $currentDateTime = new DateTime();
        //$trips_paginated[$i]->trip_headsign = $stop_times_first[$i]->stop_headsign;

            $hours_to_add = substr($stop_times_first->arrival_time, 0, 2);
            $minutes_to_add = substr($stop_times_first->arrival_time, 3, 2);
            $seconds_to_add = substr($stop_times_first->arrival_time, 6, 2);
            
            $DT = new DateTime($wdr->timestamp);
            $DT->setTime(0,0,0,0);

            $trip_first_stop_time = DateTime::createFromFormat('Y-m-d H:i:s', $DT->format('Y-m-d H:i:s'));
            if ($hours_to_add > 0)
            {
                if ($hours_to_add >= 24)
                {
                    do {
                        $DIString = 'PT24H';
                        $trip_first_stop_time->add(new DateInterval($DIString));
                        $hours_to_add -= 24;
                    } while ($hours_to_add >= 24);
                }
                $DIString = 'PT'.$hours_to_add.'H';
                $trip_first_stop_time->add(new DateInterval($DIString));
            }
            if ($minutes_to_add > 0)
            {
                $DIString = 'PT'.$minutes_to_add.'M';
                $trip_first_stop_time->add(new DateInterval($DIString));
            }
            if ($seconds_to_add > 0)
            {
                $DIString = 'PT'.$seconds_to_add.'S';
                $trip_first_stop_time->add(new DateInterval($DIString));
            }

            $this->trip_first_stop = $trip_first_stop_time->format('Y-m-d H:i:s');

            $hours_to_add = substr($stop_times_last->arrival_time, 0, 2);
            $minutes_to_add = substr($stop_times_last->arrival_time, 3, 2);
            $seconds_to_add = substr($stop_times_last->arrival_time, 6, 2);

            $trip_last_stop_time = DateTime::createFromFormat('Y-m-d H:i:s', $DT->format('Y-m-d H:i:s'));
            if ($hours_to_add > 0)
            {
                if ($hours_to_add >= 24)
                {
                    do {
                        $DIString = 'PT24H';
                        $trip_last_stop_time->add(new DateInterval($DIString));
                        $hours_to_add -= 24;
                    } while ($hours_to_add >= 24);
                }
                $DIString = 'PT'.$hours_to_add.'H';
                $trip_last_stop_time->add(new DateInterval($DIString));
            }
            if ($minutes_to_add > 0)
            {
                $DIString = 'PT'.$minutes_to_add.'M';
                $trip_last_stop_time->add(new DateInterval($DIString));
            }
            if ($seconds_to_add > 0)
            {
                $DIString = 'PT'.$seconds_to_add.'S';
                $trip_last_stop_time->add(new DateInterval($DIString));
            }
            
            $this->trip_last_stop = $trip_last_stop_time->format('Y-m-d H:i:s');
            
            //dump($trip_first_stop_time->format('Y-m-d H:i:s'). " | ". $trip_last_stop_time->format('Y-m-d H:i:s') . " | " . $currentDateTime->format('Y-m-d H:i:s'));
            if ($this->service_alert_cancled)
            {
                $this->trip_status = '3'; // Cancelled
            }
            else if ($currentDateTime < $trip_first_stop_time)
            {
                $this->trip_status = '0'; // Upcoming
            }
            else if ($currentDateTime > $trip_last_stop_time)
            {
                $this->trip_status = '2'; // Completed
            }
            else
            {
                $this->trip_status = '1'; // In progress
            }
        
        return $this;
    }
}
