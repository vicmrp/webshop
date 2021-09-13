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

// Check om session er aktiv
async function evaluate() {
    try {
        let url = 'http://' + location.hostname + '/server_checkactivesession_login_module.php'
        let accessGranted = null
        let resp = await fetch(url)
        let json = await resp.text()
        accessGranted = await JSON.parse(json)
        if (!accessGranted.loggedin) {
            console.log('http://' + location.hostname + '/login.php')
            location.replace('http://' + location.hostname + '/login.php')
        }
        return accessGranted
    } catch (error) {
        console.error(error)
    }
}

// Sleep function - returnere promis
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// ----- form events evaluation - callback ----- //
function tickWarningStop(response) {


    processing = false
    let inputReturnedTempObj

    console.log(`php respone:`)
    console.log(returnedObj.responseText)
    // console.log(JSON.parse(returnedObj.responseText))


}

function updateObject(mytypeof) {
    
}
// ----- form events evaluation - callback ----- //