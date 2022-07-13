import {defaultJavaScript} from '../global/js/default-javascript.js'; defaultJavaScript.runDefaultPageScript()
import SessionService from '../global/js/services/session-service.js';
import PostnordService from '../global/js/services/postnord-service.js';


async function init() {
    const session = await SessionService.getSession()
    const servicePoints = await PostnordService.getServicePoints(session.customer.address.street, session.customer.address.postal_code)

    console.log(servicePoints)


}init()



const generatePill =