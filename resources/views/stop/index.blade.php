<div>
    <form  action="/stop" method="get">
        <input type="text"  name="q" placeholder="Search.."/>
        <button type="submit">Search</button>
    </form>
</div>

<div>
    {!! $stops->links() !!}
</div>

@foreach ($stops as $stop)
    <div style="border-bottom: dashed black 5px">
        <a href="/stop/{{$stop->stop_id}}">
            <h1>{{$stop->stop_name}}</h1>
        </a>
        <p>Parrent station: <a href="/stop/{{$stop->parrent_station}}"></a></p>
        <p>Platform code: {{$stop->platform_code}}</p>
        <p>Stop id: {{$stop->stop_id}}</p>
    </div>
@endforeach

<div>
    {!! $stops->links() !!}
</div>