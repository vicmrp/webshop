import {defaultJavaScript} from '../global/js/default-javascript.js'; defaultJavaScript.runDefaultPageScript()
import SessionService from '../global/js/services/session-service.js'


class Customer {

    customer = {
        fullname: null,
        address: {
            street: null,
            postal_code: null,
            city: null
        },
        contact: {
            phone: null,
            email: null
        },
        company: {
            cvr_number: null,
            company_name: null
        }
    }

    constructor(fullname, street, postal_code, city, phone, email, cvr_number = null, company_name = null) {
        this.customer.fullname = fullname;
        this.customer.address.street = street;
        this.customer.address.postal_code = postal_code;
        this.customer.address.city = city;
        this.customer.contact.phone = phone;
        this.customer.contact.email = email;
        this.customer.company.cvr_number = cvr_number;
        this.customer.company.company_name = company_name;
    }
}


const fullname      = document.getElementById('fullname')
const street        = document.getElementById('street')
const postal_code   = document.getElementById('postal_code')
const city          = document.getElementById('city')
const phone         = document.getElementById('phone')
const email         = document.getElementById('email')
const btnSubmit = document.getElementById('btnSubmit')

async function main() {

    const session = await SessionService.getSession()
    fullname.setAttribute('value', session.customer.fullname)
    street.setAttribute('value', session.customer.address.street)
    postal_code.setAttribute('value', session.customer.address.postal_code)
    city.setAttribute('value', session.customer.address.city)
    phone.setAttribute('value', session.customer.contact.phone)
    email.setAttribute('value', session.customer.contact.email)
    console.log(session)

}main()

btnSubmit.addEventListener('click', async () => {

    const customer = new Customer(fullname.value, street.value, postal_code.value, city.value, phone.value, email.value)


    const session = await SessionService.updateCustomer(customer)

    if (!session.customer.details_satisfied_for_payment) return

    location.href = `${location.protocol}//${location.hostname}/postal-service`

})