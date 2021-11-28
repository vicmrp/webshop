import Interface from './interface.js'
import LoginResponse from '../models/login-response.js'

export default class Login extends Interface {

  
  #iUsername
  #iPassword
  #iButton
  #username = null
  #userCredentialsIsValid = false



  
  constructor(iUsername, iPassword, iButton) {
    super()

    this.#iUsername = iUsername,
    this.#iPassword = iPassword,
    this.#iButton   = iButton

    this.#iUsername.addEventListener("keyup", (e) => {
      if (e.key === 'Enter') this.#iButton.click() 
    })
    
    this.#iPassword.addEventListener("keyup", (e) => {
        if (e.key === 'Enter') this.#iButton.click() 
    })

    this.#iButton.addEventListener("click",async () => {
      const result = await this.getValidateUserCredentials(this.#iUsername.value, this.#iPassword.value)
      console.log(result);
    })
  }


  async get_login_status() {
    const url = `http://tspa2.byg.dtu.dk/interface.php?functioncall=get_login_status`
    const response = await this.callServerByFetchReturnObject(url)
    return response
  }


  async getValidateUserCredentials(username, password) {

    const loginFomula = {
      email: username,
      password: password
    }

    const functioncall = 'get_validated_user_credentials'
    const url = `https://steengede.com/controller/login.php?functioncall=${functioncall}`
    const body = JSON.stringify(loginFomula)

    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: body
    }    
    const serverResponse = await this.callServerByFetchReturnObject(url, options)
    const result = await this.getJavascriptModel(
      serverResponse,
      new LoginResponse()
    )
 
    return result
  }
}