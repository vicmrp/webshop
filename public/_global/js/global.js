import Header from './classes/header.js'

const global = {
  header: function () {
    const logoutBtn = document.getElementById('_header_logout')
    const header = new Header(logoutBtn)
  }
}

global.header()

