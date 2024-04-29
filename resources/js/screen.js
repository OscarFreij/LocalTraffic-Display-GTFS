//var stopQue = ["9021001005031000","9021001050392000","9021001050012000"];

function LoadNewColumns()
{
    var stop = stopQue[0];
    stopQue.push(stopQue.shift());

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById('data').innerHTML = this.responseText;
    }
    };
    xhttp.open("GET", "https://localtraffic.retune365.com/displayAPI/"+stop, true);
    xhttp.send();
}


function UpdateTime()
{
    let date = new Date();
    let h = date.getHours();
    let m = date.getMinutes();
    document.getElementById('clock').childNodes[1].innerHTML = h+":"+m;
}


function UpdateWeather()
{
    var weatherData = "";
    var weatherRow = "";
    if (!isNaN(lon) && !isNaN(lat))
    {
        let xhttp2 = new XMLHttpRequest();
        xhttp2.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            weatherData = JSON.parse(this.responseText);
        }
        };
        xhttp2.open("GET", "https://api.open-meteo.com/v1/forecast?latitude="+lat+"&longitude="+lon+"&current=temperature_2m,apparent_temperature,is_day,precipitation,rain,showers,snowfall,cloud_cover,wind_speed_10m&timezone=Europe%2FBerlin", false);
        xhttp2.send();
    }
    else
    {
        weatherData = null;
        return;
    }
    console.log(weatherData);


    if (weatherData.current.is_day == 1)
    {
        if (weatherData.current.rain == 0)
        {
            if (weatherData.current.cloud_cover < 10)
            {
                weatherRow += '<i class="bi bi-sun"></i>';
            }
            else if (weatherData.current.cloud_cover >= 10 && weatherData.current.cloud_cover <= 75)
            {
                weatherRow += '<i class="bi bi-cloud-sun-fill"></i>';
            }
            else if (weatherData.current.cloud_cover > 75)
            {
                weatherRow += '<i class="bi bi-clouds-fill"></i>';
            }
        }
        else if (weatherData.current.rain > 0 && weatherData.current.snowfall == 0)
        {
            weatherRow += '<i class="bi bi-cloud-rain-fill"></i>';
        }
        else if (weatherData.current.snowfall > 0 && weatherData.current.rain == 0)
        {
            weatherRow += '<i class="bi bi-cloud-snow-fill"></i>';
        }
        else if (weatherData.current.snowfall > 0 && weatherData.current.rain > 0)
        {
            weatherRow += '<i class="bi bi-cloud-sleet-fill"></i>';
        }


        weatherRow += " " + weatherData.current.temperature_2m + " " + weatherData.current_units.temperature_2m
    }
    else
    {
        weatherRow == "";
    }

    document.getElementById('weather').childNodes[1].innerHTML = weatherRow;

}

setInterval(() => {
    LoadNewColumns();
    UpdateTime();
}, 10000);

setInterval(() => {
    UpdateWeather();
}, 900000);

LoadNewColumns();
UpdateTime();
UpdateWeather();