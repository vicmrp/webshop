import Admin from '../_global/js/classes/admin.js'

const admin = new Admin()


admin.getAllPayments().then(object => {

  const main = document.getElementsByTagName('main')[0];
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

