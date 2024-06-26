<script type="module">
    let sum = 0;
    let countProduct = 0;
    async function getData() {
        const product = document.querySelector('.product-info');
        const data = [];
        const id = product.dataset.id;
        const price = product.querySelector('.product-price').textContent;
        let quantity = 0;
        if(product.querySelector('#quantity') != null){
            quantity = product.querySelector('#quantity').value;
        }
        countProduct = countProduct + Number(quantity);
        let totalPrice = 0;
        if(product.querySelector('#unit_value').value == 0.5){
            totalPrice = price * quantity * 0.5;
        } else{totalPrice = price * quantity}
        if(quantity == '' || quantity == 0){
            product.querySelector('.quantity').innerHTML = `
                <input type="hidden" id="quantity" value="0">
                <span class="unit">0</span>
            `;
        } else if(product.querySelector('#quantity').value > 0) {
            product.querySelector('.quantity-container').classList.remove('d-none');
            product.querySelector('.quantity-container').previousElementSibling.classList.add('d-none');
        }
        data.push({id, price, quantity});
        sum = sum + totalPrice;
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
                allBuy = basket;
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

    const product = document.querySelector('.product-info');
    let cardSum = 0;
    let productSum = 0;
    if(product.querySelector('#quantity') != null){
        productSum = Number(product.querySelector('.product-price').innerText) * Number(product.querySelector('#quantity').value);
    }
    Number(product.querySelector('.product-price').innerText) * Number(product.querySelector('.quantity').innerText);
    const productQuant = product.querySelector('.quantity');
    product.addEventListener('click' , (event) => {
        const price = Number(product.querySelector('.product-price').innerText);
        let targ = event.target
        if (targ.classList.contains('increment') || targ.classList.contains('add-cart')) {
            if(targ.classList.contains('add-cart')){
                targ.classList.add('d-none');
                targ.nextElementSibling.classList.remove('d-none');
                product.querySelector('#quantity').value++;
                product.querySelector('.unit').textContent = Number(product.querySelector('#quantity').value) * Number(product.querySelector('#unit_value').value) + product.querySelector('#unit_name').value;
                document.querySelector('.cart-count').textContent++;
            } else if(targ.classList.contains('increment')){
                product.querySelector('#quantity').value++;
                product.querySelector('.unit').textContent = Number(product.querySelector('#quantity').value) * Number(product.querySelector('#unit_value').value) + product.querySelector('#unit_name').value;
                document.querySelector('.cart-count').textContent++;
            }
            if(product.querySelector('#unit_value').value == 0.5){
                sum = sum + (price * 0.5);
            } else{sum = sum + price}
            plus(targ.dataset.id, allBuy)
            $.ajax({
                type: 'POST',
                url: '/setsession',
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), basket: allBuy }
            })  
        } else if (targ.classList.contains('decrement')) {
            product.querySelector('#quantity').value--;
            product.querySelector('.unit').textContent = Number(product.querySelector('#quantity').value) * Number(product.querySelector('#unit_value').value) + product.querySelector('#unit_name').value;
            document.querySelector('.cart-count').textContent--;
            if(product.querySelector('#quantity').value < 1){
                product.querySelector('#quantity').value = 0;
                targ.parentElement.classList.add('d-none');
                targ.parentElement.previousElementSibling.classList.remove('d-none');
            }
            if(product.querySelector('#unit_value').value == 0.5){
                sum = sum - (price * 0.5);
            } else{sum = sum - price}
            minus(targ.dataset.id, allBuy)
            $.ajax({
                type: 'POST',
                url: '/setsession',
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), basket: allBuy }
            }) 
        }
    })

</script>