<div style="border-bottom: dashed black 5px">
    <h1>{{$route->route_short_name}} {{$route->route_desc}}</h1>
    <p>route long name: {{$route->route_long_name}}</p>
    <p>route type: {{$route->route_type}}</p>
    <p>agency id: <a href="/agency/{{$route->agency_id}}">{{$route->agency_id}}</a></p>
    <p>route id: {{$route->route_id}}</p>
</div>

<div style="border-bottom: dashed black 5px">
    <h1>Connected Trips</h1>
    {{ $trips->links() }}
    @foreach ($trips as $trip)
        @dump($trip)
    @endforeach
    {{ $trips->links() }}
</div>