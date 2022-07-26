import APIService from "./api-service.js";

export default class SessionService {

    static async getSession() {
        const url = `${location.protocol}//${location.hostname}/api/session/`
        const options = {
            method: 'GET'
        }

        const call = await APIService.callServerByFetchReturnObject(url, options)
        return call.session
    }


    static async updateOrder(arrayOfProducts) {
        const url = `${location.protocol}//${location.hostname}/api/session/?update=order`
        const options = {
            method: 'PUT',
            body: JSON.stringify(arrayOfProducts)
        }

        const call = await APIService.callServerByFetchReturnObject(url, options)


        return call.session
    }

    static async updateCustomer(customer) {
        const url = `${location.protocol}//${location.hostname}/api/session/?update=customer`
        const options = {
            method: 'PUT',
            body: JSON.stringify(customer)
        }

        const call = await APIService.callServerByFetchReturnObject(url, options)

        return call.session
    }



    static async updateShipment(shipmentID) {
        const url = `${location.protocol}//${location.hostname}/api/session/?update=shipment&` + new URLSearchParams({'service-point-id': shipmentID}).toString()
        const options = {
            method: 'PUT'
        }

        const call = await APIService.callServerByFetchReturnObject(url, options)

        return call.session
    }

}