import Interface from './interface.js'

export default class Session extends Interface {

  constructor(){super()}

  // is user logged in?
  async getLoginSession() {
    const functioncall = 'get_validated_user_credentials'
    const url = `http://tspa2.byg.dtu.dk/controller/login.php?functioncall=${functioncall}`
    const body = JSON.stringify(loginFomula)
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: body
    }

    
  }

  async 

}