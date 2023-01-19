import SessionService from "../vezit-service-global/js/services/session-service.js";

// get order_id from url
const urlParams = new URLSearchParams(window.location.search);
const order_id = urlParams.get('order_id');

// request
const sessionResponse = await SessionService.getSession(order_id);

const orderCompleteContainer = document.querySelector(".order-complete__container");

if (sessionResponse.session.order.status.payment.accepted && sessionResponse.session.order.status.email.invoice_sent_to_customer) {
  // payment has been accepted and pdf has been sent to customer email
  orderCompleteContainer.innerHTML = `
    <h1>Tak for din ordre!</h1>
    <p>Din ordre er nu blevet gennemført og er bekræftet.</p>
    <p>Din pdf fil er nu sendt til <span id="email-address">victor.reipur@gmail.com</span> .</p>
    <p>Vedhæftet fil: <span id="pdf-title">Victors bog</span></p>
    <p>Tak for din support!</p>
  `;
} else {
  // payment has not been accepted
  orderCompleteContainer.innerHTML = `
    <h1>Betaling mislykkedes</h1>
    <p>Vi beklager, din ordre kunne ikke gennemføres.</p>
    <p>Kontakt os på <a href="mailto:kundeservice@example.com">kundeservice@example.com</a> for assistance.</p>
  `;
}