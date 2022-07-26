import {defaultJavaScript} from '../global/js/default-javascript.js'
import SessionService from '../global/js/services/session-service.js'

const removeAllItems = document.getElementById('remove-all-items');

const novelPlusBtn = document.getElementById('novel-plus-btn');
const novelMinusBtn = document.getElementById('novel-minus-btn');
const novelRemoveBtn = document.getElementById('novel-remove-btn');
const novelCount = document.getElementById('novel-count');
const novelPrice = document.getElementById('novel-price');
const novelItem  = document.getElementById('novel-item');

const updateOrder = sessionStorage.getItem('update_order')

let novelCountValue = 0;
let novelPriceValue = 0;

const careerPlusBtn = document.getElementById('career-plus-btn');
const careerMinusBtn = document.getElementById('career-minus-btn');
const careerRemoveBtn = document.getElementById('career-remove-btn');
const careerCount = document.getElementById('career-count');
const careerPrice = document.getElementById('career-price');
const careerItem = document.getElementById('career-item');
const checkout = document.getElementById('checkout');

let careerCountValue = 0;
let careerPriceValue = 0;

const totalPriceDisplay = document.getElementById('total-price');

const getSession = () => {
    SessionService.getSession().then(session => {
        console.log(session);


        session.order.items.forEach(item => {
            if (item.product_pk_fk === 3) {
                novelCountValue = item.quantity;
                novelPriceValue = item.price;
            } else if (item.product_pk_fk === 4) {
                careerCountValue = item.quantity;
                careerPriceValue = item.price;
            }

        })
        displayOnEvent()
    });
}

removeAllItems.addEventListener('click', () => {
    // novelItem.style.display = 'none';
    // novelCountValue = 0;

    // careerItem.style.display = 'none';
    // careerCountValue = 0;

    // displayOnEvent();
});

novelPlusBtn.addEventListener('click', async () => {
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
    getSession();
});

novelMinusBtn.addEventListener('click', async () => {
    const PRODUCT_PK_OF_NOVEL = 3

    const updateOrder = JSON.parse(sessionStorage.getItem('update_order')).map(orderItem => {
        if (orderItem.product_pk === PRODUCT_PK_OF_NOVEL) {
            orderItem.quantity -= 1

        }

        return orderItem

    })

    sessionStorage.setItem('update_order', JSON.stringify(updateOrder))

    await SessionService.updateOrder(updateOrder)

    defaultJavaScript.updatePage()
    getSession();
});

novelRemoveBtn.addEventListener('click', () => {
    // novelItem.style.display = 'none';
    // novelCountValue = 0;
    // displayOnEvent();
});

careerPlusBtn.addEventListener('click', async () => {
    const PRODUCT_PK_OF_CAREER = 4

    const updateOrder = JSON.parse(sessionStorage.getItem('update_order')).map(orderItem => {
        if (orderItem.product_pk === PRODUCT_PK_OF_CAREER) {
            orderItem.quantity += 1
        }

        return orderItem


    })

    sessionStorage.setItem('update_order', JSON.stringify(updateOrder))

    await SessionService.updateOrder(updateOrder)

    defaultJavaScript.updatePage()
    getSession();
});

careerMinusBtn.addEventListener('click', async () => {
    const PRODUCT_PK_OF_CAREER = 4

    const updateOrder = JSON.parse(sessionStorage.getItem('update_order')).map(orderItem => {
        if (orderItem.product_pk === PRODUCT_PK_OF_CAREER) {
            orderItem.quantity -= 1

        }

        return orderItem

    })

    sessionStorage.setItem('update_order', JSON.stringify(updateOrder))

    await SessionService.updateOrder(updateOrder)

    defaultJavaScript.updatePage()
    getSession();
});

careerRemoveBtn.addEventListener('click', () => {
    careerItem.style.display = 'none';
    careerCountValue = 0;
    displayOnEvent();
});

checkout.addEventListener('click', async () => {
    const session = await SessionService.getSession()
    if (0 >= session.order.items.length) {
        alert("Du har inte lagt till något i din kundvagn.")
        return
    }

    location.href = `${location.protocol}//${location.hostname}/customer`

})

function displayOnEvent(session) {
    novelCount.innerHTML = novelCountValue;
    novelPrice.innerHTML = displayPrice(novelCountValue * novelPriceValue);
    careerCount.innerHTML = careerCountValue;
    careerPrice.innerHTML = displayPrice(careerCountValue * careerPriceValue);
    totalPriceDisplay.innerHTML = 99 < novelCountValue * novelPriceValue + careerCountValue * careerPriceValue ? displayPrice(novelCountValue * novelPriceValue + careerCountValue * careerPriceValue) : '0,00 kr.';
}

function displayPrice(integerPrice) {
    return `${integerPrice.toString().substring(0, integerPrice.toString().length - 2)},${integerPrice.toString().slice(-2)} kr.`;
}

(function main() {
    defaultJavaScript.runDefaultPageScript()
    getSession()
})()