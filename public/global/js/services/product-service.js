import APIService from "./api-service.js";

export default class SessionService {

    static async getAllProducts() {
        const url = `${location.protocol}//${location.hostname}/api/product/?query=get-all-products`
        const options = {
            method: 'GET'
        }

        return await APIService.callServerByFetchReturnObject(url, options)
    }

}