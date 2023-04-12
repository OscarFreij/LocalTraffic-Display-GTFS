import './bootstrap';


var stopQue = ["9022001005031001", "9022001005031002"];

function LoadNewColumns()
{
    var stop = stopQue[0];
    stopQue.push(stopQue.shift());

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.body.innerHTML = this.responseText;
    }
    };
    xhttp.open("GET", "https://localtrafic.retune365.com/displayAPI/"+stop, true);
    xhttp.send();
}


setInterval(() => {
    LoadNewColumns();
}, 5000);

LoadNewColumns();