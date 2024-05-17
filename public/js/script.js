const sumBlock = document.querySelector('.cart-total');
let sum = 0;
let countProduct = 0;
async function getData() {
    const cards = document.querySelectorAll('.card');
    const data = [];

    cards.forEach(card => {
        const id = card.dataset.id;
        const price = card.querySelector('.card-price').textContent;
        let quantity = 0;
        if(card.querySelector('#quantity') != null){
            quantity = card.querySelector('#quantity').value;
        }
        countProduct = countProduct + Number(quantity);
        let totalCard = 0;
        if(card.querySelector('#unit_value').value == 0.5){
            totalCard = price * quantity * 0.5;
        } else{totalCard = price * quantity;}
        if(quantity == '' || quantity == 0){
            card.querySelector('.quantity').innerHTML = `
                <input type="hidden" id="quantity" value="0">
                <span class="unit">0</span>
            `;
        } else if(card.querySelector('#quantity').value > 0) {
            card.querySelector('.quantity-container').classList.remove('d-none');
            card.querySelector('.quantity-container').previousElementSibling.classList.add('d-none');
        }
        data.push({id, price, quantity});
        sum = sum + totalCard;
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

const cards = document.querySelectorAll('.card');

cards.forEach(card => {
    let cardSum = 0;
    if(card.querySelector('#quantity') != null){
        cardSum = Number(card.querySelector('.card-price').innerText) * Number(card.querySelector('#quantity').value);
    }
    const cardQuant = card.querySelector('.card-quantity');
    if(card.querySelector('#unit_value').value == 0.5){
        cardQuant.textContent = cardSum * 0.5;
    } else{cardQuant.textContent = cardSum}
    card.addEventListener('click' , (event) => {
        let price = Number(card.querySelector('.card-price').innerText);
        let targ = event.target
        if (targ.classList.contains('increment') || targ.classList.contains('add-cart')) {
            if(targ.classList.contains('add-cart')){
                targ.classList.add('d-none');
                targ.nextElementSibling.classList.remove('d-none');
                card.querySelector('#quantity').value++;
                card.querySelector('.unit').textContent = Number(card.querySelector('#quantity').value) * Number(card.querySelector('#unit_value').value) + card.querySelector('#unit_name').value;
                document.querySelector('.cart-count').textContent++;
                if(card.querySelector('#unit_value').value == 0.5){
                    cardQuant.textContent = Number(cardQuant.textContent) + (Number(card.querySelector('.card-price').innerText) * 0.5);
                } else{cardQuant.textContent = Number(cardQuant.textContent) + Number(card.querySelector('.card-price').innerText)}
            } else if(targ.classList.contains('increment')){
                card.querySelector('#quantity').value++;
                card.querySelector('.unit').textContent = Number(card.querySelector('#quantity').value) * Number(card.querySelector('#unit_value').value) + card.querySelector('#unit_name').value;
                document.querySelector('.cart-count').textContent++;
                if(card.querySelector('#unit_value').value == 0.5){
                    cardQuant.textContent = Number(cardQuant.textContent) + (Number(card.querySelector('.card-price').innerText) * 0.5);
                } else{cardQuant.textContent = Number(cardQuant.textContent) + Number(card.querySelector('.card-price').innerText)}
            }
            if(card.querySelector('#unit_value').value == 0.5){
                sum = sum + (price * 0.5);
            } else{sum = sum + price}
            
            sumBlock.textContent = sum;
            plus(targ.dataset.id, allBuy)
            $.ajax({
                type: 'POST',
                url: '/setsession',
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), basket: allBuy }
            })
        } else if (targ.classList.contains('decrement')) {
            card.querySelector('#quantity').value--;
            card.querySelector('.unit').textContent = Number(card.querySelector('#quantity').value) * Number(card.querySelector('#unit_value').value) + card.querySelector('#unit_name').value;
            document.querySelector('.cart-count').textContent--;
            if(card.querySelector('#unit_value').value == 0.5){
                cardQuant.textContent = Number(cardQuant.textContent) - (Number(card.querySelector('.card-price').innerText) * 0.5);
            } else{cardQuant.textContent = Number(cardQuant.textContent) - Number(card.querySelector('.card-price').innerText)}
            if(card.querySelector('#quantity').value < 1){
                if(document.title == 'Корзина'){
                    card.remove();
                }
                card.querySelector('#quantity').value = 0;
                targ.parentElement.classList.add('d-none');
                targ.parentElement.previousElementSibling.classList.remove('d-none');
            }
            if(card.querySelector('#unit_value').value == 0.5){
                sum = sum - (price * 0.5);
            } else{sum = sum - price}
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