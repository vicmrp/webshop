import {defaultJavaScript} from '../global/js/default-javascript.js'; defaultJavaScript.runDefaultPageScript()
import SessionService from '../global/js/services/session-service.js';

// Udfyld html med data

const btnPayment = document.querySelector('.btn-payment')

async function init() {
    const session = await SessionService.getSession()
    const invoiceAddress = document.querySelector('.invoice-address')
    const deliveryAddress = document.querySelector('.delivery-address')
    invoiceAddress.innerHTML = `
        <h3>Fakturaddresse</h3>
        <p>${session.customer.fullname}</p>
        <p>${session.customer.address.postal_code} ${session.customer.address.city}</p>
        <p>Danmark</p>
        <p>${session.customer.contact.email}</p>
        <h4>Betalingsmetode</h4>
        <p>Dankort, kreditkort</p>
    `
    deliveryAddress.innerHTML = `
        <p>${session.shipment.name}</p><!--Pakkeboks 5517 Fakta Q-->
        <p>${session.shipment.address.street_name} ${session.shipment.address.street_number}</p><!--Jernbanepladsen 49-->
        <p>${session.shipment.address.postal_code} ${session.shipment.address.city}</p>
        <p>Danmark</p>
        <h4>Leveringsmetode</h4>
        <p>Privatpakke Collect uden omdeling - Vælg selv udleveringssted</p>
    `

    console.log(session)




}init()


btnPayment.addEventListener('click', async () => {
    console.log("You clicked the button!");
    const session = await SessionService.getSession()

    if (!session.order.status.details_satisfied_for_payment) return


    location.href = `${location.protocol}//${location.hostname}/home/`
})