function httpRequest(method, url, body, callback) {
    let xhttp;
    xhttp= new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (typeof callback === "function") {
                callback(this)
            }            
        }
    };
    xhttp.open(method, url, true);
    xhttp.send(body);
}

// void sletmig
function testDebug(x) {
    console.log(x.responseText)
}

// slet mig
function sleepCallback(seconds, message) {
    httpRequest("GET", `https://steengede.com/test/sleep.php?sleep=${seconds}&msg=${message}`, null, testDebug)
}