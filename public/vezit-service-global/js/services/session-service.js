import APIService               from "./api-service.js"


// ----- Private data ----- //



export default class SessionService {

    static async getSession(order_id = null) {


        const REQUEST = 'get-session-request'

        const url = `${location.protocol}//${location.hostname}:${location.port}/vezit-service-api/session/?query=${REQUEST}&order_id=${order_id}`
        const options = {
            method: 'GET'
        }

        const callResponse = await APIService.callServerByFetchReturnObject(url, options)


        return callResponse.get_session_response

    }




    static async updateCustomer(putUpdateCustomerRequest) {


        const json = JSON.stringify({put_update_customer_request : putUpdateCustomerRequest})

        const REQUEST = 'put-update-customer-request'

        const url = `${location.protocol}//${location.hostname}:${location.port}/vezit-service-api/session/?query=${REQUEST}`
        const options = {
            method: 'PUT',
            body: json
        }

        const callResponse = await APIService.callServerByFetchReturnObject(url, options)

        return callResponse
    }





    static async getPaymentLink() {
        const REQUEST = 'get-payment-link-request'

        const url = `${location.protocol}//${location.hostname}:${location.port}/vezit-service-api/session/?query=${REQUEST}`
        const options = {
            method: 'GET'
        }

        const callResponse = await APIService.callServerByFetchReturnObject(url, options)

        return callResponse
    }



















}