import Interface from "../classes/interface.js";

export default class ProductService extends Interface {
  hello() {
    console.log("Hello World from product service")
  }

  async getAllProducts() {
    const functioncall = 'get_all_products'
    const controller = 'product'
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
