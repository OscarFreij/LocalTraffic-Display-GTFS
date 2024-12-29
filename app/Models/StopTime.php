<?php

namespace App\Models;

use DateTime;
use DateInterval;
use App\Models\Stop;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StopTime extends Model
{
    /** @use HasFactory<\Database\Factories\StopTimeFactory> */
    use HasFactory;

    function stop()
    {
        return $this->belongsTo(Stop::class, 'stop_id', 'stop_id');
    }

    function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'trip_id');
    }

    function arrivalTimeFormated()
    {
        $wdr = WorkerDataRetrievals::where('type', '=', '1')->orderBy('timestamp', 'desc')->first();
        return $this->parseGTFSTimestamp($this->arrival_time, $wdr->timestamp);
    }

    function arrivalTimeRTFormatedRT()
    {
        $wdr = WorkerDataRetrievals::where('type', '=', '1')->orderBy('timestamp', 'desc')->first();
        return $this->parseGTFSTimestamp($this->rt_arrival_time, $wdr->timestamp);
    }

    function departureTimeFormated()
    {
        $wdr = WorkerDataRetrievals::where('type', '=', '1')->orderBy('timestamp', 'desc')->first();
        return $this->parseGTFSTimestamp($this->departure_time, $wdr->timestamp);
    }

    function departureTimeRTFormated()
    {
        $wdr = WorkerDataRetrievals::where('type', '=', '1')->orderBy('timestamp', 'desc')->first();
        return $this->parseGTFSTimestamp($this->rt_departure_time, $wdr->timestamp);
    }

    private function parseGTFSTimestamp($timestamp, $baseTimestamp, $returnDateTime = false)
    {
        if (is_null($timestamp))
        {
            return null;
        }

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

        if ($returnDateTime)
        {
            return $ts;
        }
        else
        {
            return $ts->format('Y-m-d H:i:s');
        }
    }

    function status()
    {
        $wdr = WorkerDataRetrievals::where('type', '=', '1')->orderBy('timestamp', 'desc')->first();
        
        $dt = $this->parseGTFSTimestamp($this->arrival_time, $wdr->timestamp, true);
        $dtr =$this->parseGTFSTimestamp($this->rt_arrival_time, $wdr->timestamp, true);

        if (is_null($dtr))
        {
            return 0;
        }

        if ($this->service_alert_cancled)
        {
            return 3; // Cancelled
        }
        else if ($dtr > $dt)
        {
            return 2; // Late
        }
        else if ($dtr < $dt)
        {
            return 1; // Early
        }
        else
        {
            return 0; // On Time
        }
    }
}
