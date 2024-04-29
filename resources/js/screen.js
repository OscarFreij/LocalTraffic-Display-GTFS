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


setInterval(() => {
    LoadNewColumns();
    UpdateTime();
}, 10000);

LoadNewColumns();
UpdateTime();