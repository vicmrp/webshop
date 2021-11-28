import Login from '../_global/js/classes/login.js'

String.prototype.replaceAt = function(index, replacement) {
  return this.substr(0, index) + replacement + this.substr(index + replacement.length);
}

const login = new Login(
  document.getElementById('_main-login_username'),
  document.getElementById('_main-login_password'),
  document.getElementById('_main-login_button')
)