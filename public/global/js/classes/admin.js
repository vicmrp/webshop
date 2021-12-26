import Interface from "./interface.js";

export default class Admin extends Interface {

  async getAllPayments() {


    const functioncall = 'get_all_payments'
    const controller = 'quickpay'
    const url = `https://steengede.com/controller/${controller}.php?functioncall=${functioncall}`
    const body = null
    const options = {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      },
      body: body
    }    
    const serverResponse = await this.callServerByFetchReturnObject(url, options)
    return serverResponse
  }

  async getPaymentById(id) {

    const data = {
      id: id
    }


    const functioncall = 'get_payment_by_id'
    const controller = 'quickpay'
    const url = `https://steengede.com/controller/${controller}.php?functioncall=${functioncall}`
    const body = JSON.stringify(data)
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: body
    }
    const serverResponse = await this.callServerByFetchReturnObject(url, options)
    return serverResponse
  }
}