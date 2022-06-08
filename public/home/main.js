import { defaultJavaScript } from '../global/js/default-javascript.js'; defaultJavaScript.main()

const novelBuyBtn = document.getElementById('novel-buy-btn');
const careerBuyBtn = document.getElementById('career-buy-btn');












novelBuyBtn.addEventListener('click', () => {
    console.log('clicked novel buy btn');
    defaultJavaScript.elements.header.basketBtnText.innerHTML = 'Indkøbskurv(1)';
});


careerBuyBtn.addEventListener('click', () => {
    console.log('clicked career buy btn');
    defaultJavaScript.elements.header.basketBtnText.innerHTML = 'Indkøbskurv(1)';
});


async function getProducts() {

    const url = `${location.protocol}//${location.hostname}/api/product/`
    const body = null
    const options = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        body: body
    }


    const serverResponse = await callServerByFetchReturnObject(url, options)
    return serverResponse
}


async function callServerByFetchReturnObject(url, options = null) {
    const fetchResponse = await fetch(url, options)
    const response = await fetchResponse.text();
    return JSON.parse(response);
  }

console.log(getProducts());