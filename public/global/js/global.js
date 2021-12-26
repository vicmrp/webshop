import Header from './classes/header.js'
import Basket from './classes/basket.js'

const global = {
  header: function () {
    const logoutBtn = document.getElementById('_header_logout')
    const header = new Header(logoutBtn)
  },

  basket: () => {
    const basket = new Basket()
    basket.addItem("cat6 UTP Dataudtag RJ45 1-stik - Hvid", "77632", 2320, 6)
    // basket.addItem("cat 5e U/UTP Netværkskabel samler.", "CCGP89005WT", 960, 4)
  }
  
}

global.header()
global.basket()

