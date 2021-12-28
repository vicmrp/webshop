import Interface from './interface.js'
import Login from './login.js'
// import LoginResponse from '../models/login-response.js'
// import IsUserLoggedInResponse from '../models/is-user-logged-in-response.js'

export default class Header extends Interface {
  #btnHeaderLogout

  constructor(btnHeaderLogout) { 
    super()
    this.#btnHeaderLogout = btnHeaderLogout

    this.#btnHeaderLogout.addEventListener("click", async () => {
      const login = new Login()
      login.requestLogoutUser().then(object => {
        console.log(object);
      })
    })
  }
}

