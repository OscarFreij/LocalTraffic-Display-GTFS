<div style="border-bottom: dashed black 5px">
    <h1>{{$stop->stop_name}}</h1>
    <p>Lat: {{$stop->stop_lat}}</p>
    <p>Lon: {{$stop->stop_lon}}</p>
    <p>Location type: {{$stop->location_type}}</p>
    <p>Parrent station: <a href="/stop/{{$stop->parrent_station}}"></a></p>
    <p>Platform code: {{$stop->platform_code}}</p>
    <p>Stop id: {{$stop->stop_id}}</p>

    <h2>Connected Routes</h2>
    @foreach ($routes as $route)
        <a href="/route/{{$route->route_id }}">{{$route->route_short_name}} - {{$route->stop_headsign}}</a><br>
    @endforeach
    
    <h2>Timetable</h2>
    {{ $stop_times->links() }}
    @foreach ($stop_times as $stop_time)
    <div style="border: solid cyan 2px">
        <h3>{{$stop_time->stop_headsign}} - {{$stop_time->departure_time}}</h3>
        @if ($stop_time->trip->tripUpdate_record != null)
            @foreach ($stop_time->trip->tripUpdate_record->tripUpdate_StopTimeUpdate as $tripUpdate_stopTimeUpdate)
                @if ($tripUpdate_stopTimeUpdate->stop_id == $stop->stop_id)
                    <p>Departure delay: {{$tripUpdate_stopTimeUpdate->departure_delay}} sec</p>
                @endif
            @endforeach
        @endif
    </div>
    @endforeach
    {{ $stop_times->links() }}
</div>