

export default class Interface {

  async callServerByFetchReturnObject(url, options = null) {
    const fetchResponse = await fetch(url, options);
    const response = await fetchResponse.text();
    return JSON.parse(response);
  }


  callServerByHttpRequestCallback(method, url, body, callback) {
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


  async testIfServerResponseIsEqualToModel(expectedProperties, serverResponse) {
    let count = 0
  expectedProperties.forEach(expectedProperty => { 
    for (const [property, value] of Object.entries(serverResponse)) {
      if (expectedProperty === property)
        count++
    }
    });

    return new Promise(function(resolve, reject) {
      resolve((count === expectedProperties.length) ? true : false)
    })
  }

 
}
