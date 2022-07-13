import { defaultJavaScript } from '../global/js/default-javascript.js';
import SessionService from '../global/js/services/session-service.js';

defaultJavaScript.runDefaultPageScript()

const novelBuyBtn = document.getElementById('novel-buy-btn');
const careerBuyBtn = document.getElementById('career-buy-btn');



novelBuyBtn.addEventListener('click', async () => {

    console.log('clicked novel buy btn');

    const PRODUCT_PK_OF_NOVEL = 3

    const updateOrder = JSON.parse(sessionStorage.getItem('update_order')).map(orderItem => {
        if (orderItem.product_pk === PRODUCT_PK_OF_NOVEL) {
            orderItem.quantity += 1
        }

        return orderItem
    })

    sessionStorage.setItem('update_order', JSON.stringify(updateOrder))

    await SessionService.updateOrder(updateOrder)

    defaultJavaScript.updatePage()

});


careerBuyBtn.addEventListener('click', async () => {
    console.log('clicked career buy btn');

    const PRODUCT_PK_OF_CAREER = 4

    const updateOrder = JSON.parse(sessionStorage.getItem('update_order')).map(orderItem => {
        if (orderItem.product_pk === PRODUCT_PK_OF_CAREER) {
            orderItem.quantity += 1
        }

        return orderItem}
    )

    sessionStorage.setItem('update_order', JSON.stringify(updateOrder))

    await SessionService.updateOrder(updateOrder)

    defaultJavaScript.updatePage()
});
