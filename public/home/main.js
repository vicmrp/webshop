import SessionService from "../vezit-service-global/js/services/session-service.js";

// request
import PutUpdateCustomerRequest from "../vezit-service-global/js/dto/put-update-customer-request/put-update-customer-request.js";
import Contact from "../vezit-service-global/js/dto/put-update-customer-request/contact/contact.js";


// For each time the user types in the fullname- and email field, we want to update the customer in the database

async function handleInput() {
    // create instance of PutUpdateCustomerRequest
    let fullname = document.getElementById('fullname');
    let email = document.getElementById('email');
    let terms = document.getElementById('terms');
    let pay_now_btn = document.getElementById('pay_now_btn');

    let contact = new Contact(email.value);

    let putUpdateCustomerRequest = new PutUpdateCustomerRequest(fullname.value, terms.checked, contact);

    let response = await SessionService.updateCustomer(putUpdateCustomerRequest);
    console.log(response.put_update_customer_response.customer.customer_details_is_satisfied);

    if (response.put_update_customer_response.customer.customer_details_is_satisfied) {

        pay_now_btn.disabled = false;
        pay_now_btn.innerHTML = "✅ Køb nu";

    } else {

        pay_now_btn.disabled = true;
        pay_now_btn.innerHTML = "🚫 Køb nu";

    }




}



async function handlePayNow() {


    let quickpay_link = await SessionService.getPaymentLink();

    if (quickpay_link.get_payment_link_response.payment_link === null) {
        alert("Du skal udfylde alle felterne");
    } else {
        console.log("redirecting to quickpay");

        window.location.href = quickpay_link.get_payment_link_response.payment_link;
    }

}


fullname.addEventListener('input', handleInput);
email.addEventListener('input', handleInput);
terms.addEventListener('input', handleInput);
pay_now_btn.addEventListener('click', handlePayNow);



