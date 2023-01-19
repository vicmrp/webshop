export default class APIService {

    static async callServerByFetchReturnObject(url, options = null) {
        try {
            const fetchResponse = await fetch(url, options)
            console.log("status:"+fetchResponse.status)
            console.log("statusText:"+fetchResponse.statusText)
            if (fetchResponse.ok) {
                const response = await fetchResponse.text();
                try {
                    return JSON.parse(response);
                } catch(e) {
                    console.log("Error Parsing JSON: "+response);
                    return e
                }
            } else {
                console.log("Error: "+fetchResponse.status+" "+fetchResponse.statusText);
                return fetchResponse.status;
            }
        }catch(error){
           console.log("Error: "+error);
        }
    }

}
