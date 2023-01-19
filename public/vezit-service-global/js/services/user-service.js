import APIService from "./api-service.js"


export default class UserService {

    static async login(postLoginRequest) {

        const json = JSON.stringify({ post_login_request : postLoginRequest })
        // const json = JSON.stringify({put_update_customer_request : putUpdateCustomerRequest})

        const REQUEST = 'post-login-request'


        const url = `${location.protocol}//${location.hostname}:${location.port}/vezit-service-api/user/?query=${REQUEST}`
        const options = {
            method: 'POST',
            body: json
        }

        const callResponse = await APIService.callServerByFetchReturnObject(url, options)

        return callResponse
    }


    static async logout() {
        const REQUEST = 'get-logout-request'

        const url = `${location.protocol}//${location.hostname}:${location.port}/vezit-service-api/user/?query=${REQUEST}`
        const options = {
            method: 'GET'
        }

        const callResponse = await APIService.callServerByFetchReturnObject(url, options)

        return callResponse
    }
}