import Login from '../_global/js/classes/login.js'

const iUsername = document.getElementById('_main-login_username')
const iPassword = document.getElementById('_main-login_password')
const iButton = document.getElementById('_main-login_button')

const login = new Login()

login.addEventListeners(iUsername, iPassword, iButton)