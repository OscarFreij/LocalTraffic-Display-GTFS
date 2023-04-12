<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  @vite('resources/css/animation.css')
</head>
<body class="text-zinc-50 bg-zinc-700">
  <div class="statusBox alert pr-24" data-state="ontime" style="">
    <div class="statusBox-content flex flex-row text-3xl p-2 bg-zinc-500 rounded-r-xl">
        <span class="basis-6/12 text-start self-center flex flex-row">
        <span class="text-start self-center">
          40
        </span>
        <span class="text-start self-center">
          &nbsp;-&nbsp;
        </span>
        <span class="text-start self-center">
          Uppsala Central
        </span>
        </span>
        <span class="basis-3/12 text-center self-center">15:30</span>
        <span class="basis-3/12 text-center self-center">12 min</span>
        <span class="basis-3/12 text-end self-center">On Time</span>
    </div>
  </div>
  <br>
  <div class="statusBox alert pr-24" data-state="low" style="">
    <div class="statusBox-content flex flex-row text-3xl p-2 bg-zinc-500 rounded-r-xl">
        <span class="basis-6/12 text-start self-center flex flex-row">
        <span class="text-start self-center">
          000
        </span>
        <span class="text-start self-center">
          &nbsp;-&nbsp;
        </span>
        <span class="text-start self-center">
          DESTINATION
        </span>
        </span>
        <span class="basis-3/12 text-center self-center">00:00</span>
        <span class="basis-3/12 text-center self-center">0 min</span>
        <span class="basis-3/12 text-end self-center">STATE</span>
    </div>
  </div>
  <br>
  <div class="statusBox alert pr-24" data-state="high" style="">
    <div class="statusBox-content flex flex-row text-3xl p-2 bg-zinc-500 rounded-r-xl">
        <span class="basis-6/12 text-start self-center flex flex-row">
        <span class="text-start self-center">
          000
        </span>
        <span class="text-start self-center">
          &nbsp;-&nbsp;
        </span>
        <span class="text-start self-center">
          DESTINATION
        </span>
        </span>
        <span class="basis-3/12 text-center self-center">00:00</span>
        <span class="basis-3/12 text-center self-center">0 min</span>
        <span class="basis-3/12 text-end self-center">STATE</span>
    </div>
  </div>
  <br>
  <div class="statusBox alert pr-24" data-state="canceled" style="">
    <div class="statusBox-content flex flex-row text-3xl p-2 bg-zinc-500 rounded-r-xl">
        <span class="basis-6/12 text-start self-center flex flex-row">
        <span class="text-start self-center">
          000
        </span>
        <span class="text-start self-center">
          &nbsp;-&nbsp;
        </span>
        <span class="text-start self-center">
          DESTINATION
        </span>
        </span>
        <span class="basis-3/12 text-center self-center">00:00</span>
        <span class="basis-3/12 text-center self-center">0 min</span>
        <span class="basis-3/12 text-end self-center">STATE</span>
    </div>
  </div>
  @vite('resources/js/app.js')
</body>
</html>