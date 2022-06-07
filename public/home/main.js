import {defaultJavaScript} from '../global/js/default-javascript.js'; defaultJavaScript.main()

const novelBuyBtn = document.getElementById('novel-buy-btn');
const careerBuyBtn = document.getElementById('career-buy-btn');


novelBuyBtn.addEventListener('click', () => {
    console.log('clicked novel buy btn');
    defaultJavaScript.elements.header.basketBtnText.innerHTML = '1';
});


careerBuyBtn.addEventListener('click', () => {
    console.log('clicked career buy btn');
});