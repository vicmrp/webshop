
import Contact from "./contact/contact.js";


export default class PutUpdateCustomerRequest {


    constructor(
        fullname = null
        ,tos_and_tac_has_been_accepted = null
        ,contact = new Contact
        ) {
            this.fullname                           = fullname
            this.tos_and_tac_has_been_accepted      = tos_and_tac_has_been_accepted
            this.contact                            = contact
            Object.seal(this)
        }
}