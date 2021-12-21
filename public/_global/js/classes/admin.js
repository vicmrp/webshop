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
}