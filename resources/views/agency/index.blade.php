<div>
    <form  action="/agency" method="get">
        <input type="text"  name="q" placeholder="Search.."/>
        <button type="submit">Search</button>
    </form>
</div>

<div>
    {!! $agencies->links() !!}
</div>

@foreach ($agencies as $agency)
    <div style="border-bottom: dashed black 5px">
        <a href="/agency/{{$agency->agency_id}}">
            <h1>{{$agency->agency_name}}</h1>
        </a>
        <p>Agency url: <a href="{{$agency->agency_url}}">{{$agency->agency_url}}</a></p>
        <p>Agency id: {{$agency->agency_id}}</p>
    </div>
@endforeach

<div>
    {!! $agencies->links() !!}
</div>