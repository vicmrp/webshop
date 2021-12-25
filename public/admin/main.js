import Admin from '../_global/js/classes/admin.js'
import Login from '../_global/js/classes/login.js';

const main = async () => {
  const login = new Login()
  const isUserLoggedInResponse = await login.checkIfUserIsLoggedIn()
  if(isUserLoggedInResponse.userIsLoggedIn === false)
    location.replace(`https://${location.hostname}/login?coming_from=${location.pathname}`)
    const admin = new Admin()

    admin.getAllPayments().then(object => {
    
      const main = document.getElementById('main_get-payments');
      const tbl = document.createElement('table');
      const tbdy = document.createElement('tbody');
      const trHeader = document.createElement('tr')
      tbdy.appendChild(trHeader)
      tbl.appendChild(tbdy)
      main.appendChild(tbl)
    
      const headers = ['id', 'order_id', 'accepted'] 
      headers.forEach(element => {
        const child = document.createElement("th")
        child.innerHTML = element
        trHeader.appendChild(child)
      })
    
    
      for (const [key, nestedObject] of Object.entries(object)) {
    
        const tr = document.createElement('tr')
    
        const id = document.createElement('td')
        const orderId = document.createElement('td')
        const accepted = document.createElement('td')
    
        id.innerHTML = nestedObject.id
        
        orderId.innerHTML = nestedObject.order_id
        accepted.innerHTML = nestedObject.accepted
        tr.appendChild(id)
        tr.appendChild(orderId)
        tr.appendChild(accepted)
    
        tbdy.appendChild(tr)
    
    
    
    
      }
    
    
    
    })
        
    const getPaymentByIdResponse = await admin.getPaymentById(275689149)
    console.log(getPaymentByIdResponse)

} 

main()