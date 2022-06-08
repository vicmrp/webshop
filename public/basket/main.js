import {defaultJavaScript} from '../global/js/default-javascript.js'; defaultJavaScript.main()


// session =
const removeAllItems = document.getElementById('remove-all-items');

const novelPlusBtn = document.getElementById('novel-plus-btn');
const novelMinusBtn = document.getElementById('novel-minus-btn');
const novelRemoveBtn = document.getElementById('novel-remove-btn');
const novelCount = document.getElementById('novel-count');
const novelPrice = document.getElementById('novel-price');
const novelItem  = document.getElementById('novel-item');

let novelCountValue = 1;
let novelPriceValue = 25000;

const careerPlusBtn = document.getElementById('career-plus-btn');
const careerMinusBtn = document.getElementById('career-minus-btn');
const careerRemoveBtn = document.getElementById('career-remove-btn');
const careerCount = document.getElementById('career-count');
const careerPrice = document.getElementById('career-price');
const careerItem = document.getElementById('career-item');
let careerCountValue = 1;
let careerPriceValue = 40000;
let totalPrice = 0;

const totalPriceDisplay = document.getElementById('total-price');


removeAllItems.addEventListener('click', () => {
    novelItem.style.display = 'none';
    novelCountValue = 0;

    careerItem.style.display = 'none';
    careerCountValue = 0;

    displayOnEvent();
});

novelPlusBtn.addEventListener('click', () => {
    novelCount.innerHTML = ++novelCountValue;
    displayOnEvent();
});

novelMinusBtn.addEventListener('click', () => {
    novelCount.innerHTML = (novelCountValue - 1) < 1 ? 1 : --novelCountValue;
    displayOnEvent();
});

novelRemoveBtn.addEventListener('click', () => {
    novelItem.style.display = 'none';
    novelCountValue = 0;
    displayOnEvent();
});

careerPlusBtn.addEventListener('click', () => {
    careerCount.innerHTML = ++careerCountValue;
    displayOnEvent();
});

careerMinusBtn.addEventListener('click', () => {
    careerCount.innerHTML = (careerCountValue - 1) < 1 ? 1 : --careerCountValue;
    displayOnEvent();
});

careerRemoveBtn.addEventListener('click', () => {
    careerItem.style.display = 'none';
    careerCountValue = 0;
    displayOnEvent();
});

function main() {
    totalPrice = novelCountValue * novelPriceValue + careerCountValue * careerPriceValue;
    displayOnEvent();
}main();

function displayOnEvent() {
    novelCount.innerHTML = novelCountValue;
    novelPrice.innerHTML = displayPrice(novelCountValue * novelPriceValue);
    careerCount.innerHTML = careerCountValue;
    careerPrice.innerHTML = displayPrice(careerCountValue * careerPriceValue);
    totalPriceDisplay.innerHTML = 99 < novelCountValue * novelPriceValue + careerCountValue * careerPriceValue ? displayPrice(novelCountValue * novelPriceValue + careerCountValue * careerPriceValue) : '0,00 kr.';
}

function displayPrice(integerPrice) {
    return `${integerPrice.toString().substring(0, integerPrice.toString().length - 2)},${integerPrice.toString().slice(-2)} kr.`;
}
