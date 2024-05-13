let sum = 0;
let countProduct = 0;
async function getData() {
    const product = document.querySelector('.product-info');
    const data = [];
    const id = product.dataset.id;
    const price = product.querySelector('.product-price').textContent;
    let quantity = product.querySelector('.quantity').textContent;
    countProduct = countProduct + Number(quantity);
    let totalPrice = price * quantity;
    if(quantity == ''){
        product.querySelector('.quantity').textContent = 0;
        quantity = 0;
    } else if(product.querySelector('.quantity').textContent > 0) {
        product.querySelector('.quantity-container').classList.remove('d-none');
        product.querySelector('.quantity-container').previousElementSibling.classList.add('d-none');
    }
    // console.log(quantity);
    data.push({id, price, quantity});
    sum = sum + totalPrice;
    document.querySelector('.cart-count').textContent = countProduct;
    return data;
}

async function getSession(){
    $.ajax({
        type: 'GET',
        url: '/getsession'
    })
    .done(function(basket, sum){
        if(basket.length < 1){
            allBuy = [] 
        } else {
            allBuy = basket
        }
    })
}
let allBuy = [];
await getSession();




function plus(id, arr) {
    if (arr.length === 0) {
        arr.push({[id]: 1})
    } else {
        if (arr.some((item) => Object.keys(item)[0] === id)) {
            arr.forEach(item => {
                if (Object.keys(item)[0] === id) {
                    item[id]++
                }
            })
        } else {
            arr.push({[id]: 1})
        }
    }
    console.log(arr)
}

function minus(id, arr) {
    if (arr.some((item) => Object.keys(item)[0] === id)) {
        arr.forEach((item, index) => {
            if (Object.keys(item)[0] === id) {
                if (item[id] > 1) {
                    item[id]--
                }
                else {
                    arr.splice(index, 1)
                }
            } 
        })
    }
}

let data = document.addEventListener('DOMContentLoaded', () => {getData();})
// console.log(data);

const product = document.querySelectorAll('.product-info');


let productSum = Number(product.querySelector('.product-price').innerText) * Number(product.querySelector('.quantity').innerText);
const productQuant = product.querySelector('.quantity');
productQuant.textContent = productSum ;
product.addEventListener('click' , (event) => {
    const price = Number(product.querySelector('.product-price').innerText);
    // console.log(price);
    let targ = event.target
    if (targ.classList.contains('increment') || targ.classList.contains('add-cart')) {
        if(targ.classList.contains('add-cart')){
            targ.classList.add('d-none');
            targ.nextElementSibling.classList.remove('d-none');
            targ.nextElementSibling.querySelector('.quantity').textContent++;
            document.querySelector('.cart-count').textContent++;
            productQuant.textContent = Number(productQuant.textContent) + Number(product.querySelector('.card-price').innerText)
        } else if(targ.classList.contains('increment')){
            targ.previousElementSibling.textContent++;
            document.querySelector('.cart-count').textContent++;
            productQuant.textContent = Number(productQuant.textContent) + Number(product.querySelector('.card-price').innerText);
        }
        sum = sum + price;
        plus(targ.dataset.id, allBuy)
        $.ajax({
            type: 'POST',
            url: '/setsession',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), basket: allBuy }
        })
        localStorage.setItem('basket', JSON.stringify(allBuy))  
    } else if (targ.classList.contains('decrement')) {
        targ.nextElementSibling.textContent--;
        document.querySelector('.cart-count').textContent--;
        productQuant.textContent = Number(productQuant.textContent) - Number(product.querySelector('.card-price').innerText);
        if(targ.nextElementSibling.innerText < 1){
            targ.nextElementSibling.textContent = 0;
            targ.parentElement.classList.add('d-none');
            targ.parentElement.previousElementSibling.classList.remove('d-none');
        }
        sum = sum - price;
        minus(targ.dataset.id, allBuy)
        $.ajax({
            type: 'POST',
            url: '/setsession',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), basket: allBuy }
        }) 
    }
})
