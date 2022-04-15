import Header from './classes/header.js'
import SessionService from './services/session-service.js'
// export default global

// const globalElementsID = {
//   header: () => {
//     const elements = {
//       homeBtn: document.getElementById('_header_logo_container')
//     }
//     new HeaderService(elements)
//   }
// }
// globalElementsID.header()

export const global = {
  sessionService: new SessionService(),
  header: {
    elements: {
      homeBtn: document.getElementById('header-logo-container')
    },
    header: new Header(this.elements)
  }
}

// global.sessionService.getSession().then(response => {
//   console.log(response);
// })

// global.sessionService.addOrderItem(1,5).then(response => {
//   console.log(response);
// })

// global.sessionService.addOrderItem(2,0).then(response => {
//   console.log(response);
// })

// global.sessionService.setCustomer("Victor Reipur", "26129604", "victor.reipur@gmail.com", "vinkelvej 12d, 3tv", "2800", "Lyngby", null, null)
// .then(() => {
//   global.sessionService.setShipmentAddress(3).then(() => {
//     global.sessionService.createPayment().then(() => {
//       global.sessionService.getPaymentLink().then(response => {
//         console.log(response);
//       })
//     })
//   })
// })
