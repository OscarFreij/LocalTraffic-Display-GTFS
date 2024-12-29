<?php

namespace App\Models;

use DateTime;
use DateInterval;
use App\Models\StopTime;
use App\Models\Transfer;
use App\Models\Filters\StopNameFilter;
use Illuminate\Database\Eloquent\Model;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use App\Models\Filters\StopHasParentStationFilter;
use Lacodix\LaravelModelFilter\Traits\IsSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use function PHPUnit\Framework\isNull;

class Stop extends Model
{
    /** @use HasFactory<\Database\Factories\StopFactory> */
    use HasFactory;
    use IsSearchable;
    use HasFilters;

    protected array $searchable = [
        'stop_name',
    ];

    protected array $filters = [
        StopNameFilter::class,
        StopHasParentStationFilter::class,
    ];
    

    protected $primaryKey = 'stop_id';

    function stopTimes()
    {
        return $this->hasMany(StopTime::class, 'stop_id', 'stop_id');
    }

    function transfers()
    {
        return $this->hasMany(Transfer::class, 'from_stop_id', 'stop_id');
    }

    function parentStation()
    {
        return $this->belongsTo(Stop::class, 'parent_station', 'stop_id');
    }

    function childStations()
    {
        return $this->hasMany(Stop::class, 'parent_station', 'stop_id');
    }

    function locationTypeString()
    {
        switch ($this->location_type) {
            case 0:
                return "Stop";
            case 1:
                return "Station";
            case 2:
                return "Station Entrance/Exit";
            case 3:
                return "Generic Node";
            case 4:
                return "Boarding Area";
            default:
                return "Unknown";
        }
    }

    function stopTimes_paginated()
    {
        $stopTimes_paginated = $this->stopTimes()->orderBy('arrival_time', 'asc')->paginate(request()->get('limit', 10))->withQueryString();

        $wdr = WorkerDataRetrievals::where('type', '=', '1')->orderBy('timestamp', 'desc')->first();

        $currentDateTime = new DateTime();

        for ($i = 0; $i < count($stopTimes_paginated); $i++) {
            $stopTimes_paginated[$i]->status = 'On Time';
            $stopTimes_paginated[$i]->arrival_time = $this->parseGTFSTimestamp($stopTimes_paginated[$i]->arrival_time, $wdr->timestamp);
            if (!isNull($stopTimes_paginated[$i]->rt_arrival_time))
            {
                $stopTimes_paginated[$i]->rt_arrival_time = $this->parseGTFSTimestamp($stopTimes_paginated[$i]->rt_arrival_time, $wdr->timestamp);
                if (!isNull($stopTimes_paginated[$i]->schedule_relationship))
                {
                    $stopTimes_paginated[$i]->status = 'Cancelled';
                }
                else if ($stopTimes_paginated[$i]->rt_arrival_time < $currentDateTime)
                {
                    $stopTimes_paginated[$i]->status = 'Late';
                }
                else if ($stopTimes_paginated[$i]->rt_arrival_time > $currentDateTime)
                {
                    $stopTimes_paginated[$i]->status = 'Early';
                }
            }
            $stopTimes_paginated[$i]->departure_time = $this->parseGTFSTimestamp($stopTimes_paginated[$i]->departure_time, $wdr->timestamp);
            if (!isNull($stopTimes_paginated[$i]->rt_departure_time))
            {
                $stopTimes_paginated[$i]->rt_departure_time = $this->parseGTFSTimestamp($stopTimes_paginated[$i]->rt_departure_time, $wdr->timestamp);
            }
        }

        return $stopTimes_paginated;
    }

    private function parseGTFSTimestamp($timestamp, $baseTimestamp)
    {
        $hours_to_add = substr($timestamp, 0, 2);
        $minutes_to_add = substr($timestamp, 3, 2);
        $seconds_to_add = substr($timestamp, 6, 2);

        $DT = new DateTime($baseTimestamp);
        $DT->setTime(0,0,0,0);

        $ts = DateTime::createFromFormat('Y-m-d H:i:s', $DT->format('Y-m-d H:i:s'));
        if ($hours_to_add > 0)
        {
            if ($hours_to_add >= 24)
            {
                do {
                    $DIString = 'PT24H';
                    $ts->add(new DateInterval($DIString));
                    $hours_to_add -= 24;
                } while ($hours_to_add >= 24);
            }
            $DIString = 'PT'.$hours_to_add.'H';
            $ts->add(new DateInterval($DIString));
        }
        if ($minutes_to_add > 0)
        {
            $DIString = 'PT'.$minutes_to_add.'M';
            $ts->add(new DateInterval($DIString));
        }
        if ($seconds_to_add > 0)
        {
            $DIString = 'PT'.$seconds_to_add.'S';
            $ts->add(new DateInterval($DIString));
        }

        return $ts->format('Y-m-d H:i:s');
    }
}
