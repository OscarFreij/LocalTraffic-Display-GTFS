//var stopQue = ["9021001005031000","9021001050392000","9021001050012000"];

var newData = ""
var firstRun = true;

const delay = ms => new Promise(res => setTimeout(res, ms));

async function LoadNewColumns()
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
        var readyToContinue = false
        var stop = stopQue[i];
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            newData += this.responseText;
            readyToContinue = true;
        }
        };
        xhttp.open("GET", "https://localtraffic.retune365.com/displayAPI/"+stop+"/2x2/4", true);
        xhttp.send();
        while (!readyToContinue)
        {
            await delay(1000);
        }
    }
}


setInterval(() => {
    LoadNewColumns();
}, 10000);

LoadNewColumns();


