import InterfaceService from './interface-service.js'

export default class SessionService extends InterfaceService {

  constructor(){super()}

  async destroySession() {
    const functioncall = 'destroy_session'
    const url = `${location.protocol}//${location.hostname}/controller/session.php?functioncall=${functioncall}`
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

  async getSession() {
    const functioncall = 'get_session'
    const url = `${location.protocol}//${location.hostname}/controller/session.php?functioncall=${functioncall}`
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

  async addOrderItem(productID, quantity) {
    const functioncall = 'add_order_item'
    const url = `${location.protocol}//${location.hostname}/controller/session.php?functioncall=${functioncall}`
    const body = JSON.stringify({
      product_id: productID,
      quantity:   quantity
    })
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

  async setCustomer(fullname, phone, email, street, postalCode, city, cvrNumber, companyName) {
      const functioncall = 'set_customer'
      const url = `${location.protocol}//${location.hostname}/controller/session.php?functioncall=${functioncall}`
      const body = JSON.stringify({
        fullname: fullname,
        phone: phone,
        email: email,
        street: street,
        postal_code: postalCode,
        city: city,
        cvr_number: cvrNumber,
        company_name: companyName
      })
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

  async getServicePoints() {
    const functioncall = 'get_service_points'
    const url = `${location.protocol}//${location.hostname}/controller/postnord.php?functioncall=${functioncall}`
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
  
  async setShipmentAddress(index) {
    const functioncall = 'set_shipment_address'
    const url = `${location.protocol}//${location.hostname}/controller/postnord.php?functioncall=${functioncall}`
    const body = JSON.stringify({
      index: index
    })
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

  async createPayment() {
    const functioncall = 'create_payment'
    const url = `${location.protocol}//${location.hostname}/controller/quickpay.php?functioncall=${functioncall}`
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

  async getPaymentLink() {
    const functioncall = 'get_payment_link'
    const url = `${location.protocol}//${location.hostname}/controller/quickpay.php?functioncall=${functioncall}`
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