@foreach ($tripUpdates as $tripUpdate)
    <div style="border-bottom: dashed black 5px">
        <a href="/tripUpdate/{{$tripUpdate->id}}">
            <h1>{{$tripUpdate->id}}</h1>
        </a>
        <p>
            {{$tripUpdate->content}}
        </p>
    </div>
@endforeach