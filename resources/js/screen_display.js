const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.style.display = ''; // Show
    } else {
      entry.target.style.display = 'none'; // Hide
    }
  });
}, {
  root: null, // The viewport
  threshold: 1.0, // Fully visible
});

document.querySelectorAll('.hidden-outside-view').forEach((el) => {
  observer.observe(el);
});



var $ts0 = -1

var $queue = new Array();
var $sourceQueue = new Array();
var $activeStop = new Object();
var $childStationCount = 0;
var $childStationIndex = 0;
var $firstStart = true;
var $firstCycle = true;
var $resetOnEOQ = false;
var $skipWeatherUntillForceReset = false;
var $weatherDataHourly = "";
var $weatherData = "";

function UpdateTime() {
  if (document.getElementsByName('footerClock') != null) {
    let date = new Date();
    let h = String(date.getHours()).padStart(2, '0');
    let m = String(date.getMinutes()).padStart(2, '0');
    let Y = String(date.getFullYear());
    let M = String(date.getMonth() + 1).padStart(2, '0');
    let D = String(date.getDate()).padStart(2, '0');

    var clockRow = ""
    clockRow += "<span>" + h + ":" + m + "</span>"
    clockRow += "<span>" + D + "/" + M + "/" + Y + "</span>"

    document.getElementsByName('footerClock').forEach(element => {
      element.childNodes[1].innerHTML = clockRow;
    });
  }
}

async function getScreenData($screen_id) {
  const requestURL = "/api/screen/" + $screen_id + "/data";
  const request = new Request(requestURL);
  const response = await fetch(request, { cache: "no-store" });
  let $tempScreenDataJSON = await response.json();

  let $tempScreen = structuredClone(screen);
  $tempScreen.stop_queue.forEach(element => {
    delete element.departures
  });

  if (JSON.stringify($tempScreen) != JSON.stringify($tempScreenDataJSON.screen) && !$firstStart) {
    $resetOnEOQ = true;
    console.log("Screen settings changed! Forced reload at next EOQ...");
  } else {
    console.log("No new screen settings found...");
  }
}

async function getDepartures($stop_id, $travle_time) {
  const requestURL = "/api/departures/" + $stop_id + "?stop_travle_time=" + $travle_time;
  const request = new Request(requestURL);
  const response = await fetch(request, { cache: "no-store" });
  let $tempDepartureJSON = await response.json();
  return $tempDepartureJSON.departures;
}

async function getAllDepartures() {
  $sourceQueue = new Array();
  await Promise.all(screen.stop_queue.map(async (stop) => {
    let $stop_object = screen.stop_queue.find(element => element.stop_id == stop.stop_id);
    $stop_object.departures = await getDepartures(stop.stop_id, stop.travle_time);
    $sourceQueue.push($stop_object);

    $sourceQueue.sort((a, b) => (a.order > b.order) ? 1 : -1);
  }));
}

function generateDepartureRow($departure) {
  let $row = null;
  if ($departure != false) {
    let $now = new Date();
    let $departureDate = new Date();
    let $tempDepartureDateArray = $departure.departure_time.split(':');
    $departureDate.setHours($tempDepartureDateArray[0], $tempDepartureDateArray[1], $tempDepartureDateArray[2])

    switch ($departure.status) {
      case 0: // On time
        $row = document.getElementsByName('template_row_onTime')[0].childNodes[1].cloneNode(true);
        $row.getElementsByTagName('p')[0].innerHTML = ($departure.trip.route.route_short_name + "&nbsp;:&nbsp;" + $departure.stop_headsign);
        $row.getElementsByTagName('p')[1].innerHTML = ($departure.departure_time);
        $row.getElementsByTagName('p')[2].innerHTML = Math.round((($departureDate - $now) / 1000) / 60) + " min";
        break;
      case 1: // Early
        $row = document.getElementsByName('template_row_early')[0].childNodes[1].cloneNode(true);
        $row.getElementsByTagName('p')[0].innerHTML = ($departure.trip.route.route_short_name + "&nbsp;:&nbsp;" + $departure.stop_headsign);
        $row.getElementsByTagName('p')[1].getElementsByTagName('span')[0].innerHTML = ($departure.departure_time);
        $row.getElementsByTagName('p')[1].getElementsByTagName('span')[1].innerHTML = ($departure.rt_departure_time);
        $row.getElementsByTagName('p')[2].innerHTML = Math.round((($departureDate - $now) / 1000) / 60) + " min";
        break;
      case 2: // Delayed
        $row = document.getElementsByName('template_row_late')[0].childNodes[1].cloneNode(true);
        $row.getElementsByTagName('p')[0].innerHTML = ($departure.trip.route.route_short_name + "&nbsp;:&nbsp;" + $departure.stop_headsign);
        $row.getElementsByTagName('p')[1].getElementsByTagName('span')[0].innerHTML = ($departure.departure_time);
        $row.getElementsByTagName('p')[1].getElementsByTagName('span')[1].innerHTML = ($departure.rt_departure_time);
        $row.getElementsByTagName('p')[2].innerHTML = Math.round((($departureDate - $now) / 1000) / 60) + " min";
        break;
      case 3: // Cancelled
        $row = document.getElementsByName('template_row_cancelled')[0].childNodes[1].cloneNode(true);
        $row.getElementsByTagName('p')[0].innerHTML = ($departure.trip.route.route_short_name + "&nbsp;:&nbsp;" + $departure.stop_headsign);
        $row.getElementsByTagName('p')[1].innerHTML = ($departure.departure_time);
        $row.getElementsByTagName('p')[2].innerHTML = "CANCELED";
        break;

      default: // Unknown - Assume on time
        $row = document.getElementsByName('template_row_onTime')[0].childNodes[1].cloneNode(true);
        $row.getElementsByTagName('p')[0].innerHTML = ($departure.trip.route.route_short_name + "&nbsp;:&nbsp;" + $departure.stop_headsign);
        $row.getElementsByTagName('p')[1].innerHTML = ($departure.departure_time);
        $row.getElementsByTagName('p')[2].innerHTML = Math.round((($departureDate - $now) / 1000) / 60) + " min";
        break;
    }
  }
  else { // If no departures are found, $departure is false. Set $row to "empty" template.
    $row = document.getElementsByName('template_row_noDepartures')[0].childNodes[1].cloneNode(true);
  }

  $row.classList.remove('hidden');
  $row.classList.add('hidden-outside-view');
  return $row;
}

async function setup() {
  document.getElementsByName('stop_name')[0].innerHTML = "Loading... Please wait!";
  console.log("Starting setup...");

  await getAllDepartures();

  $queue = $queue.concat(($sourceQueue));

  console.log("Setup complete!");
  console.log("Starting main loop...");
  console.log("Screen settings: " + screen.short_name);


  $ts0 = setInterval(async () => {

    if ($queue.length < $sourceQueue.length && !$resetOnEOQ) {
      console.log("Queue length less than stop_queue length! Adding departure source queue to end...");
      $queue = $queue.concat($sourceQueue);
    }

    if ($firstStart) {
      $activeStop = $queue.shift();
    }

    if ($activeStop.combine_children == "1") {

      document.getElementsByName('stop_name')[0].innerHTML = $activeStop.departures[0].stop.stop_name;

      let $combinedDepartures = new Array();
      $activeStop.departures.forEach(element => {
        $combinedDepartures = $combinedDepartures.concat(element.stop_times);
      });

      $combinedDepartures.sort((a, b) => (a.departure_time > b.departure_time) ? 1 : -1);

      let $combinedDeparturesFiltered = new Array();

      $combinedDepartures.forEach(element => {
        if (element.rt_departure_time != null) {
          if (element.rt_departure_time >= new Date().toISOString()) {
            $combinedDeparturesFiltered.push(element);
          }
        }
        else if (element.departure_time >= new Date().toISOString()) {
          $combinedDeparturesFiltered.push(element);
        }
      });

      // ADD DEPARTURES TO SCREEN
      document.getElementById('stops-container').innerHTML = "";
      if ($combinedDepartures.length == 0) {
        document.getElementById('stops-container').appendChild(generateDepartureRow(false));
      }
      else {
        $combinedDepartures.forEach(element => {
          document.getElementById('stops-container').appendChild(generateDepartureRow(element));
        });
      }

      document.querySelectorAll('.hidden-outside-view').forEach((el) => {
        observer.observe(el);
      });
      $activeStop = $queue.shift();

    } else if ($activeStop.combine_children == "0") {
      if ($childStationIndex < $activeStop.departures.length) {
        document.getElementsByName('stop_name')[0].innerHTML = $activeStop.departures[$childStationIndex].stop.stop_name + "&nbsp; (Platform: " + $activeStop.departures[$childStationIndex].stop.platform_code + ")";

        // ADD DEPARTURES TO SCREEN

        document.getElementById('stops-container').innerHTML = "";
        if ($activeStop.departures[$childStationIndex].stop_times.length == 0) {
          document.getElementById('stops-container').appendChild(generateDepartureRow(false));
        }
        else {
          $activeStop.departures[$childStationIndex].stop_times.forEach(element => {
            document.getElementById('stops-container').appendChild(generateDepartureRow(element));
          });
        }
        document.querySelectorAll('.hidden-outside-view').forEach((el) => {
          observer.observe(el);
        });
        $childStationIndex++;
      }

      if ($childStationIndex == $activeStop.departures.length) {
        $childStationIndex = 0;
        $activeStop = $queue.shift();
      }
    }


    console.log("Active stop: " + $activeStop.stop_id);
    console.log("Combine all children?: " + $activeStop.combine_children);
    $firstCycle = false;
    $firstStart = false;

    if ($queue.length == 0 && $resetOnEOQ) {
      console.log("End of queue reached! Resetting screen...");
      location.reload(true);
    }

  }, screen.time_per_stop * 1000);

}


const $tsS = setInterval(async () => {
  console.log("Checking screen settings for updates...");
  await getScreenData(screen.short_name);
  await getAllDepartures();
}, 60000);


setup();