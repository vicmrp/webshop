import {defaultJavaScript} from '../global/js/default-javascript.js'; defaultJavaScript.runDefaultPageScript()
import SessionService from '../global/js/services/session-service.js';
import PostnordService from '../global/js/services/postnord-service.js';


async function init() {
    const session = await SessionService.getSession()
    const servicePoints = await PostnordService.getServicePoints(session.customer.address.street, session.customer.address.postal_code)

    servicePoints.forEach(servicePoint => {
        const servicePointElement = document.createElement('div')
        servicePointElement.classList.add('service-point')
        servicePointElement.innerHTML = `
            <div id="${servicePoint.service_point_id}">
                <div class="service-point-name">${servicePoint.name}</div>
                <div class="service-point-postal-code-and-city">${servicePoint.postal_code} ${servicePoint.city}</div>
                <div class="service-point-road">${servicePoint.street_name} ${servicePoint.street_number}</div>
            </div>
        `
        servicePointElement.addEventListener('click', async () => {
            console.log(servicePoint.service_point_id)

            const session = await SessionService.updateShipment(servicePoint.service_point_id)

            console.log(session.shipment.name);

            if (!session.shipment.details_satisfied_for_payment) return

            location.href = `${location.protocol}//${location.hostname}/checkout/`
        })

        document.querySelector('.service-points').appendChild(servicePointElement)
    });
}init()

