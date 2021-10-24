function callServerByHttpRequestCallback(method, url, body, callback) {
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

async function callServerByFetchReturnObject(url, options = null) {
    const fetchResponse = await fetch(url, options);
    const response = await fetchResponse.text();
    return JSON.parse(response);
}