//var stopQue = ["9021001005031000","9021001050392000","9021001050012000"];

var newData = ""
var firstRun = true;

function LoadNewColumns()
{
    if (!firstRun)
    {
        document.getElementById('data').innerHTML = newData;
        newData = ""
    }
    else
    {
        firstRun = false;
    }
    
    for (let i = 0; i < stopQue.length; i++) {
        var stop = stopQue[i];
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            newData += this.responseText;
        }
        };
        xhttp.open("GET", "https://localtraffic.retune365.com/displayAPI/"+stop+"/2x2/4", true);
        xhttp.send();
    }
}


setInterval(() => {
    LoadNewColumns();
}, 10000);

LoadNewColumns();