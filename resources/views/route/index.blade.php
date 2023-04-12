<div>
    <form  action="/route" method="get">
        <input type="text"  name="q" placeholder="Search.."/>
        <button type="submit">Search</button>
    </form>
</div>

<div>
    {!! $routes->links() !!}
</div>

@foreach ($routes as $route)
    <div style="border-bottom: dashed black 5px">
        <a href="/route/{{$route->route_id}}">
            <h1>{{$route->route_short_name}} {{$route->route_desc}}</h1>
        </a>
        <p>Agency: <a href="/agency/{{$route->agency_id}}">{{$route->agency->agency_name}}</a></p>
    </div>
@endforeach

<div>
    {!! $routes->links() !!}
</div>