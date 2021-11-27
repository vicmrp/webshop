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
      // const login_reponse = await this.get_login_status()
      // console.log("Hello World");
      // console.log(login_reponse);
      
      // console.log(user);
    })
  }


  async get_login_status() {
    const url = `http://tspa2.byg.dtu.dk/interface.php?functioncall=get_login_status`
    const response = await this.callServerByFetchReturnObject(url)
    return response
  }


  async getValidateUserCredentials(username, password) {

    console.log("evaluating");

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

    const requiredModelProperties = ['email', 'user_credentials_is_valid', 'php_session_is_active']

    const loginResponse = await this.setModel(serverResponse, model)

    const result = await this.testIfServerResponseIsEqualToModel(requiredModelProperties, serverResponse)
    console.log(result)

    console.log(serverResponse);
    
    
    // const valuereturn = (result) ? 
    //   new LoginResponse(
    //     serverResponse.username,
    //     serverResponse.groupmember,
    //     serverResponse.user_credentials_is_valid,
    //     serverResponse.php_session_is_active
    //   ) : console.error(`Missing expected properties`)

    // return new Promise(function(resolve, reject) {
    //   resolve(valuereturn)
    // })

    

    return
        

    // // console.log(serverResponse);
    // const loginResponse = new LoginResponse(serverResponse.username,serverResponse.groupmember,serverResponse.user_credentials_is_valid)
    // return loginResponse
  }
}