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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script>var stopQue = {{ Js::from($carousel_data_array) }};</script>
  @vite('resources/css/app.css')
  @vite('resources/css/statusBox.css')
  @vite('resources/js/app.js')
</head>
<body class="text-zinc-50 bg-zinc-700">
  @if (!is_null($screen_data->long_name))
  <div class="w-full mb-1">
    <h1 class="text-center text-4xl">{{$screen_data->long_name}}</h1>
  </div>
  @endif
  <div id="data" class="divide-zinc-700 divide-y-4">

  </div>
</body>
</html>