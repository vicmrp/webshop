import APIService from "./api-service.js"

export default class PostnordService {
    static async getServicePoints(streetname, postalCode) {
        const url = `${location.protocol}//${location.hostname}/api/postnord/?` + new URLSearchParams({
            streetname: streetname,
            'zip-code': postalCode
        }).toString()


        const options = {
            method: 'GET'
        }

        return await APIService.callServerByFetchReturnObject(url, options)
    }
}