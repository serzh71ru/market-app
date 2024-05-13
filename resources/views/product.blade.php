<x-head>
    <x-slot:title>
    {{ $product->name }}
    </x-slot>
</x-head>
<body>
    <header>
        <x-navbar/>
            <img src="{{ asset("storage/$product->image") }}" class="product-img d-block w-100" alt="{{ $product->name }}">
    </header>
    <main class="my-5">
        <div class="product-info container" data-id='{{$product->id}}'>
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <button class="btn btn-outline-success add-cart" data-id='{{$product->id}}'>В корзину | <span class="product-price">{{ $product->price }}</span>Р</button>
            <div class="quantity-container my-3 d-flex d-none">
                <button class="decrement btn btn-outline-success" data-id='{{$product->id}}'>-</button>
                
                <span class="quantity btn btn-outline-success mx-2">
                    @if (isset($basket))
                        @foreach ($basket as $item)
                            @foreach ($item as $id => $quantity)
                                @if ($id == $product->id)
                                    {{ $quantity }}
                                    
                                @endif
                                
                            @endforeach
                        @endforeach
                    @endif
                </span>
                <button class="increment btn btn-outline-success" data-id='{{$product->id}}'>+</button>
            </div>
        </div>
    </main>
    <hr>
    <x-footer/>
    <script type="module">
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
            data.push({id, price, quantity});
            sum = sum + totalPrice;
            // document.querySelector('.cart-count').textContent = countProduct;
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
                    let allCount = 0;
                    allBuy.forEach(product => {
                        allCount = allCount + Number(Object.values(product)[0])
                    })
                    document.querySelector('.cart-count').textContent = allCount;
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
        // console.log(await getData());

        const product = document.querySelector('.product-info');


        let productSum = Number(product.querySelector('.product-price').innerText) * Number(product.querySelector('.quantity').innerText);
        const productQuant = product.querySelector('.quantity');
        // productQuant.textContent = productSum ;
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
                    // productQuant.textContent = Number(productQuant.textContent) ++
                } else if(targ.classList.contains('increment')){
                    targ.previousElementSibling.textContent++;
                    document.querySelector('.cart-count').textContent++;
                    // productQuant.textContent = Number(productQuant.textContent) ++;
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
                // productQuant.textContent = Number(productQuant.textContent) -1;
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

    </script>
    <x-scripts/>
</body>
