import Interface from './interface.js'
import Login from './login.js'
// import LoginResponse from '../models/login-response.js'
// import IsUserLoggedInResponse from '../models/is-user-logged-in-response.js'

export default class Header extends Interface {
  #homeBtn
  #logoutBtn

  constructor(elements) { 
    super()
    this.#homeBtn   = elements.homeBtn
    this.#logoutBtn = elements.logoutBtn


    this.#logoutBtn.addEventListener("click", async () => {
      const login = new Login()
      login.requestLogoutUser().then(object => {
        console.log(object);
      })
    })

    this.#homeBtn.addEventListener("click", () => {
      location.href = `${location.protocol}//${location.hostname}`
    })
  }
}

