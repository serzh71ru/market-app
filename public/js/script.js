const sumBlock = document.querySelector('.cart-total');
let sum = 0;
let countProduct = 0;
async function getData() {
    const cards = document.querySelectorAll('.card');
    const data = [];

    cards.forEach(card => {
        const id = card.dataset.id;
        const price = card.querySelector('.card-price').textContent;
        let quantity = card.querySelector('.quantity').textContent;
        countProduct = countProduct + Number(quantity);
        let totalCard = price * quantity;
        if(quantity == ''){
            card.querySelector('.quantity').textContent = 0;
            quantity = 0;
        } else if(card.querySelector('.quantity').textContent > 0) {
            card.querySelector('.quantity-container').classList.remove('d-none');
            card.querySelector('.quantity-container').previousElementSibling.classList.add('d-none');
        }
        // console.log(quantity);
        data.push({id, price, quantity});
        sum = sum + totalCard;
        document.querySelector('.cart-count').textContent = countProduct;
        sumBlock.textContent = sum;
    });
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

const cards = document.querySelectorAll('.card');

// async function renderQuantityCard(){
//     cards.forEach(card => {
//         let quantity = card.querySelector('.quantity');

//     })
// }

// let basket = localStorage.getItem('basket')



cards.forEach(card => {
    let cardSum = Number(card.querySelector('.card-price').innerText) * Number(card.querySelector('.quantity').innerText);
    const cardQuant = card.querySelector('.card-quantity');
    cardQuant.textContent = cardSum ;
    card.addEventListener('click' , (event) => {
        const price = Number(card.querySelector('.card-price').innerText);
        // console.log(price);
        let targ = event.target
        if (targ.classList.contains('increment') || targ.classList.contains('add-cart')) {
            if(targ.classList.contains('add-cart')){
                targ.classList.add('d-none');
                targ.nextElementSibling.classList.remove('d-none');
                targ.nextElementSibling.querySelector('.quantity').textContent++;
                document.querySelector('.cart-count').textContent++;
                cardQuant.textContent = Number(cardQuant.textContent) + Number(card.querySelector('.card-price').innerText)
            } else if(targ.classList.contains('increment')){
                targ.previousElementSibling.textContent++;
                document.querySelector('.cart-count').textContent++;
                cardQuant.textContent = Number(cardQuant.textContent) + Number(card.querySelector('.card-price').innerText);
            }
            sum = sum + price;
            sumBlock.textContent = sum;
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
            cardQuant.textContent = Number(cardQuant.textContent) - Number(card.querySelector('.card-price').innerText);
            if(targ.nextElementSibling.innerText < 1){
                if(document.title == 'Корзина'){
                    card.remove();
                }
                targ.nextElementSibling.textContent = 0;
                targ.parentElement.classList.add('d-none');
                targ.parentElement.previousElementSibling.classList.remove('d-none');
            }
            sum = sum - price;
            sumBlock.textContent = sum;
            if(sumBlock.innerText == 0 && document.title == 'Корзина'){
                document.querySelector('.form').remove();
                document.querySelector('.container').innerHTML = `
                <div class="empty-cart border-2 rounded-3 py-3 px-3">
                    <div class="card-body d-flex justify-content-between">
                        <h3 class="card-title">Корзина пуста</h3>
                        <a href="/" class="btn btn-success">В каталог</a>
                    </div>
                </div>
                `;
            }
            minus(targ.dataset.id, allBuy)
            $.ajax({
                type: 'POST',
                url: '/setsession',
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), basket: allBuy }
            }) 
        }
    })
})