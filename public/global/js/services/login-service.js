import InterfaceService from './interface-service.js'
import LoginResponse from '../models/login-response.js'
import IsUserLoggedInResponse from '../models/is-user-logged-in-response.js'

export default class LoginService extends InterfaceService {

  
  #iUsername
  #iPassword
  #iButton
  
  constructor() { super() }


  addEventListeners(iUsername, iPassword, iButton) {
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
      const result = await this.getValidateUserCredentials(
        this.#iUsername.value, this.#iPassword.value
        )

      if (result.accessGranted === true)  {

        // const currentUrl = location.href
        const url = new URL(location.href)
        const comingFrom = url.searchParams.get("coming_from")


        const redirection = (comingFrom !== null) ? comingFrom : '/home/'
        location.replace(`https://${location.hostname}${redirection}`)
      }
      console.log(result);
    })
  }





  async getValidateUserCredentials(username, password) {

    const loginFomula = {
      username: username,
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




  async checkIfUserIsLoggedIn() {

    const functioncall = 'check_if_user_is_logged_in'
    const url = `https://steengede.com/controller/login.php?functioncall=${functioncall}`
    const body = null
    const options = {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      },
      body: body
    }

    const serverResponse = await this.callServerByFetchReturnObject(url, options)
    const result = await this.getJavascriptModel(
      serverResponse,
      new IsUserLoggedInResponse()
    )

    return result
  }

  async requestLogoutUser() {
    
    // const result = (IsUserLoggedInResponse.userIsLoggedIn === true) ? true : 
    const functioncall = 'logout'
    const url = `https://steengede.com/controller/login.php?functioncall=${functioncall}`
    const body = null
    const options = {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      },
      body: body
    }


    const serverResponse = await this.callServerByFetchReturnObject(url, options)
    const result = await this.getJavascriptModel(
      serverResponse,
      new IsUserLoggedInResponse()
    )
    return result

  }
}
