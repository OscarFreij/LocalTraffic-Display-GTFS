<?php

namespace App\Models;

use App\Models\Trip;
use App\Models\Agency;
use App\Models\StopTime;
use App\Models\WorkerDataRetrievals;
use App\Models\Filters\RouteNameFilter;
use DateTime;
use DateInterval;
use Illuminate\Database\Eloquent\Model;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use Lacodix\LaravelModelFilter\Traits\IsSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    /** @use HasFactory<\Database\Factories\RouteFactory> */
    use HasFactory;
    use IsSearchable;
    use HasFilters;

    protected array $searchable = [
        'route_short_name',
    ];

    protected array $filters = [
        RouteNameFilter::class,
    ];

    protected $primaryKey = 'route_id';

    protected $casts = [
        'route_id' => 'string',
        'agency_id' => 'string',
        'route_short_name' => 'string',
        'route_long_name' => 'string',
        'route_desc' => 'string',
        'route_type' => 'string',
    ];


    function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'agency_id');
    }

    function trips()
    {
        return $this->hasMany(Trip::class, 'route_id', 'route_id');
    }

    function route_desc_string()
    {
        switch ($this->route_desc) {
            case '100':
                return "Railway Service";
            case '101':
                return "High Speed Rail Service";
            case '102':
                return "Long Distance Rail Service";
            case '105':
                return "Sleeper Rail Service";
            case '106':
                return "Regional Rail Service";
            case '401':
                return "Metro Service";
            case '700': 
                return "Bus Service";
            case '714':
                return "Rail Replacement Bus Service";
            case '900':
                return "Tram Service";
            case '1000':
                return "Water Transport Service";
            case '1501':
                return "Communal Taxi Service";
            default:
                return "Other";
        }
    }

    function trips_paginated()
    {
        
        $trips_paginated = $this->trips()->orderBy('trip_id', 'asc')->paginate(request()->get('limit', 10))->withQueryString();
        $stop_times_first = StopTime::whereIn('trip_id', $trips_paginated->pluck('trip_id'))->orderBy('trip_id', 'asc')->where('stop_sequence', '=', 1)->get();
        //$stop_times_last = StopTime::whereIn('trip_id', $trips_paginated->pluck('trip_id'))->orderBy('trip_id', 'asc')->orderBy('stop_sequence', 'desc')->distinct('trip_id')->get();
        $stop_times_last = StopTime::whereIn('trip_id', $trips_paginated->pluck('trip_id'))
            ->orderBy('trip_id', 'asc')
            ->orderBy('stop_sequence', 'desc')
            ->get()
            ->unique('trip_id')
            ->values();

        $wdr = WorkerDataRetrievals::where('type', '=', '1')->orderBy('timestamp', 'desc')->first();

        $currentDateTime = new DateTime();

        for ($i = 0; $i < count($stop_times_first); $i++) {
            $trips_paginated[$i]->trip_headsign = $stop_times_first[$i]->stop_headsign;

            $hours_to_add = substr($stop_times_first[$i]->arrival_time, 0, 2);
            $minutes_to_add = substr($stop_times_first[$i]->arrival_time, 3, 2);
            $seconds_to_add = substr($stop_times_first[$i]->arrival_time, 6, 2);
            
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

            $trips_paginated[$i]->trip_first_stop = $trip_first_stop_time->format('Y-m-d H:i:s');

            $hours_to_add = substr($stop_times_last[$i]->arrival_time, 0, 2);
            $minutes_to_add = substr($stop_times_last[$i]->arrival_time, 3, 2);
            $seconds_to_add = substr($stop_times_last[$i]->arrival_time, 6, 2);

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
            
            $trips_paginated[$i]->trip_last_stop = $trip_last_stop_time->format('Y-m-d H:i:s');
            
            //dump($trip_first_stop_time->format('Y-m-d H:i:s'). " | ". $trip_last_stop_time->format('Y-m-d H:i:s') . " | " . $currentDateTime->format('Y-m-d H:i:s'));
            if ($trips_paginated[$i]->service_alert_cancled)
            {
                $trips_paginated[$i]->trip_status = '3'; // Cancelled
            }
            else if ($currentDateTime < $trip_first_stop_time)
            {
                $trips_paginated[$i]->trip_status = '0'; // Upcoming
            }
            else if ($currentDateTime > $trip_last_stop_time)
            {
                $trips_paginated[$i]->trip_status = '2'; // Completed
            }
            else
            {
                $trips_paginated[$i]->trip_status = '1'; // In progress
            }
        }

        

        return $trips_paginated;
    }
}
