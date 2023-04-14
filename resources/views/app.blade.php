@php
  if (str_contains($carousel_data, '-'))
  {
    $carousel_data_array = explode('-', $carousel_data);
  }
  else
  {
    $carousel_data_array = array("$carousel_data");
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
</body>
</html>