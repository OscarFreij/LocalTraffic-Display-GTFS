@php
  if (str_contains($screen_data->stop_que, ','))
  {
    $carousel_data_array = explode(',', $screen_data->stop_que);
  }
  else
  {
    $carousel_data_array = array("$screen_data->stop_que");
  }
    
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.5">
  <script>
    var stopQue = {{ Js::from($carousel_data_array) }};
    var lon = {{ Js::from($screen_data->lon) }};
    var lat = {{ Js::from($screen_data->lat) }};
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  @vite('resources/css/app.css')
  @vite('resources/css/statusBox.css')
  @vite('resources/css/legend.css')
  @vite('resources/js/app.js')
  @vite('resources/js/screen2x2.js')
</head>
<body class="text-zinc-50 bg-zinc-700 static">
  <div class="flex mt-3 mb-1">
    <div class="w-1/4" id="weather">
      <p class="text-start text-3xl ml-5"></p>
    </div>
    <div class="w-1/2">
      @if (!is_null($screen_data->long_name))
      <h1 class="text-center text-4xl">{{$screen_data->long_name}}</h1>
      @endif
    </div>
    <div class="w-1/4" id="clock">
      <p class="text-end text-3xl mr-5">00:00</p>
    </div>
  </div>
  

  <div id="data" class="flex flex-wrap gap-y-3">
    <h1 class="text-center text-4xl w-full">LOADING DATA...</h1>
  </div>
  
  <div id="legend" class="bottom-0 absolute text-center text-2xl flex flex-nowrap w-full justify-center gap-4 mb-1 mt-auto	">
    <div class="legend-color pb-3" data-state="ontime">
      <span class="px-2 bg-zinc-600 font-bold">I tid</span>
    </div>
    <div class="legend-color pb-3" data-state="early">
      <span class="px-2 bg-zinc-600 font-bold">Tidig</span>
    </div>
    <div class="legend-color pb-3" data-state="late">
      <span class="px-2 bg-zinc-600 font-bold">Sen</span>
    </div>
    <div class="legend-color pb-3" data-state="cancelled">
      <span class="px-2 bg-zinc-600 font-bold">Inställd</span>
    </div>
  </div>
</body>
</html>