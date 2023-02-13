
import APIService from '../vezit-service-global/js/services/api-service.js';





const url = `${location.protocol}//${location.hostname}:${location.port}/vezit-service-api/user/?query=get-logout-request`
const options = {
    method: 'GET'
}



APIService.callServerByFetchReturnObject(url, options).then(response => {
    console.log(response);
    if (!response.post_login_response.access_granted) {
        window.location.replace(`${location.protocol}//${location.hostname}:${location.port}/login`)
    }
})

