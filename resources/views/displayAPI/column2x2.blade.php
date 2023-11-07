<div class="2x2-data-cell w-1/2 p-1.5">
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

        
        if ($plannedDepartureTime == $delayedDepartureTime)
        {
            $state = "ontime";
        }
        else if ($plannedDepartureTime < $delayedDepartureTime)
        {
            $state = "late";
        }
        else if ($plannedDepartureTime > $delayedDepartureTime)
        {
            $state = "early";
        }
        
        if (isset($stop_time->trip_schedule_relationship))
        {
            if ($stop_time->trip_schedule_relationship == 3)
            {
                $state = "canceled";
            }
        }
        
        if (isset($stop_time->stop_time_schedule_relationship))
        {
            if ($stop_time->stop_time_schedule_relationship != 0)
            {
                $state = "canceled";
            }
        }

        if ($stop_time->serviceAlertCancelled == 1)
        {
            $state = "cancelled";
            $timeDiff = "Cancelled";
        }
        else if ($timeDiff < 0)
        {
            $state = "departed";
        }
        else if ($timeDiff == 0)
        {
            $timeDiff = "NOW";
        }
        else 
        {
            $timeDiff = $timeDiff." min";
        }
        
    @endphp
    <div class="statusBox alert pb-3" data-state="{{$state}}" style="">
        <div class="statusBox-content flex md:flex-row flex-col text-3xl p-2 bg-zinc-600">
            <span class="md:basis-6/12 basis-full text-start self-center flex flex-row">
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
            @if(is_numeric($stop_time->platform_code))
            <span class="md:basis-2/12 basis-full text-center self-center">
                Track: {{$stop_time->platform_code}}
            </span>
            @else
            <span class="md:basis-2/12 basis-full text-center self-center"></span>
            @endif
            <span class="md:basis-2/12 basis-full text-center self-center">
            @if ($state == "ontime")
                <span class="">{{$plannedDepartureTime}}</span>
            @else
                <span class="line-through">{{$plannedDepartureTime}}</span>&nbsp;-&nbsp;<span class="text-red-500">{{$delayedDepartureTime}}</span>
            @endif
            </span>
            <span class="md:basis-2/12 basis-full text-center self-center">{{$timeDiff}}</span>
        </div>
    </div>
    @endforeach
</div>