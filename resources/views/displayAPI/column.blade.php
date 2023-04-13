<div class="w-full">
    <h1 class="text-center text-4xl">{{$master_stop_data->stop_name}}</h1>
</div>

@foreach ($stop_times as $stop_time)
@php
    if (substr($source_download_data->timestamp, 0, 10) == date('Y-m-d'))
    {
        
        if (substr($stop_time->departure_time, 0, 2) > 23)
        {
            $newTime = (substr($stop_time->departure_time, 0, 2) - 24).(substr($stop_time->departure_time, 2));
            $planned = new DateTimeImmutable($newTime);
            $planned = $planned->modify('+1 day');
        }
        else
        {
            $planned = new DateTimeImmutable($stop_time->departure_time);
        }
    }
    else
    {
        if (substr($stop_time->departure_time, 0, 2) > 23)
        {
            $newTime = (substr($stop_time->departure_time, 0, 2) - 24).(substr($stop_time->departure_time, 2));
            $planned = new DateTimeImmutable($newTime);
        }
        else
        {
            $planned = new DateTimeImmutable($stop_time->departure_time);
        }
    }

    $delay = $planned;
    $now = new DateTimeImmutable(date('H:i:s'));
    if ($stop_time->rt_departure_time != null)
    {
        $delay = new DateTimeImmutable($stop_time->rt_departure_time);
        $interval = $delay->diff($now, false);
    }
    else
    {
        $interval = $planned->diff($now, false);   
    }

    $hours = $interval->format('%H');
    $minutes = $interval->format('%i');

    if ($interval->invert)
    {
        $timeDiff = (($hours * 60)+$minutes);
    }
    else
    {
        $timeDiff = (($hours * 60)+$minutes)*-1;
    }

    
    
    $plannedDepartureTime = $planned->format('H:i');
    $delayedDepartureTime = $delay->format('H:i');

    $state = "ontime";
    if ($timeDiff < 0)
    {
        $state = "departed";
    }
    else if ($timeDiff <= 10)
    {
        $state = "high";
    }
    else if ($timeDiff <= 15)
    {
        $state = "low";
    }

    if ($timeDiff == 0)
    {
        $timeDiff = "NOW";
    }
    else {
        $timeDiff = $timeDiff." min";
    }

    if ($plannedDepartureTime == $delayedDepartureTime)
    {
        $tripState = "On Time";
    }
    else
    {
        $tripState = "Delayed";
    }

    
@endphp
<div class="statusBox alert pb-3 my-1" data-state="{{$state}}" style="">
    <div class="statusBox-content flex flex-row text-3xl p-2 bg-zinc-600">
        <span class="basis-6/12 text-start self-center flex flex-row">
        <span class="text-start self-center">
            {{$stop_time->trip->route->route_short_name}}
        </span>
        <span class="text-start self-center">
            &nbsp;-&nbsp;
        </span>
        <span class="text-start self-center">
            {{$stop_time->stop_headsign}}
        </span>
        </span>
        <span class="basis-3/12 text-center self-center">
        @if ($tripState == "On Time")
            <span class="">{{$plannedDepartureTime}}</span>
        @else
            <span class="line-through">{{$plannedDepartureTime}}</span>&nbsp;-&nbsp;<span class="text-red-500">{{$delayedDepartureTime}}</span>
        @endif
        </span>
        <span class="basis-3/12 text-center self-center">{{$timeDiff}}</span>
    </div>
</div>
@endforeach