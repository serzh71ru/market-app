<x-head>
    <x-slot:title>
    Корзина
    </x-slot>
</x-head>
<body>
    <header>
        <x-navbar/>
    </header>
    <main class="cart-main pt-5">
        
        <div class="container">
            
            {{-- <div class="products row"> --}}
                @if (isset($basket))
                    <div class=" w-100 d-md-flex d-none flex-md-row col-12  justify-content-between align-items-center text-secondary">
                        <div style="width:250px"><h6></h6></div>
                        <h4 class="card-title me-5">Товар</h4>
                        <h4 class="d-none d-lg-block"><span class="card-price me-3">Цена</span></h4>
                        <div class="d-flex justify-content-between align-items-center  mx-lg-5">
                            <h4 class="mx-4">Количество</h4>
                            <h4>Сумма</h4>
                        </div>
                    </div>
                    <hr>
                    @php
                        $sum = 0;
                    @endphp
                    @foreach ($products as $product)
                        <div class=" w-100 card border-0 d-block d-md-flex flex-md-row text-decoration-none col-12 col-md-3 col-xl-2 my-2 justify-content-between align-items-center" data-id='{{$product->id}}' href="{{ route('product', ['slug' => $product->slug]) }}">
                            <img src="{{ asset("storage/$product->image") }}" alt="{{ $product->name }}" class="card-img cart-card-img w-sm-100">
                            <h4 class="card-title">{{ $product->name }}</h4>
                            <h4 class="d-none d-lg-block"><span class="card-price ms-5">{{ $product->price }}</span> <span>Р</span></h4>
                            <div class="d-flex justify-content-between align-items-center  mx-lg-5">
                                <button class="btn btn-outline-success w-sm-25 w-50 my-3 add-cart" data-id='{{$product->id}}'>В корзину</button>
                                <div class="quantity-container my-3 my-md-1 d-flex d-none justify-content-center mx-md-5">
                                    <button class="decrement btn btn-outline-success" data-id='{{$product->id}}'>-</button>
                                    <span class="quantity btn btn-outline-success mx-2">
                                        @foreach ($basket as $item)
                                            @foreach ($item as $id => $quantity)
                                                @if ($id == $product->id)
                                                    @php
                                                        $sum = $sum + ($product->price * $quantity);
                                                    @endphp
                                                    {{ $quantity }}
                                                @endif
                                                
                                            @endforeach
                                        @endforeach
                                    </span>
                                    <button class="increment btn btn-outline-success" data-id='{{$product->id}}'>+</button>
                                </div>
                                <h4><span class="card-quantity"></span>Р</h4>
                            </div>
                        </div>
                        <hr class="d-md-none">
                    @endforeach
                    <hr>
                    <div class="total d-flex justify-content-between">
                        <h2>Итого:</h2>
                        <h2>
                            <span class="cart-total">{{ $sum }}</span>
                            <span>Р</span>
                        </h2>
                    </div>
                    <hr>
                @else
                    <div class="empty-cart border-2 rounded-3 py-3 px-3">
                        <div class="card-body d-flex justify-content-between">
                            <h3 class="card-title">Корзина пуста</h3>
                            <a href="{{ route('home') }}" class="btn btn-success">В каталог</a>
                        </div>
                    </div>
                @endif
            {{-- </div> --}}
        </div>
        @if (isset($basket))
            <div class="order container mt-5">
                <h3 class="mb-5">Оформление заказа</h3>
                <form action="#" method="POST" class="order mb-5 container d-flex flex-column align-items-center">
                    @csrf
                    <div class="form-group w-50">
                        <label for="name" class="mt-2">Ваше имя:</label>
                        @if (auth()->check())
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        @else
                            <input type="text" name="name" id="name" class="form-control" placeholder="Введите имя">
                        @endif
                        
                        
                        <label for="email" class="mt-2">Ваш email:</label>
                        @if (auth()->check())
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        @else
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        @endif
                        <label for="phone" class="mt-2">Телефон для связи</label>
                        @if (auth()->check())
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="username" />
                        @else
                            <input type="phone" name="phone" id="phone" class="form-control" placeholder="Телефон">
                        @endif
                    </div>
                    <div class="form-group mx-4 w-50">
                        @csrf
                        {{-- @dd($addresses) --}}
                        <div class="mt-2 mb-1">Адрес доставки:</div>
                        @foreach ($addresses as $address)
                            <div class="d-flex align-items-center">
                                <input type="radio" id="{{ $address->id }}" name="adress">
                                <label for="{{ $address->id }}" class="form-control ms-3">{{ $address->address }}</label>
                            </div>                        
                        @endforeach
                        <label for="address" class="mt-2">Другой адрес</label>
                        <div class="mt-1 d-flex align-items-center">
                            <input type="radio" class="mt-1" name="adress">
                            <div class="w-100 ms-3">
                                <input type="text" class="form-control mt-1 w-100" name="address" id="address" required>
                            </div>
                        </div> 
                        <div class="d-flex flex-column mt-3">
                            <label for="info">Доп. информация об адресе доставки</label>
                            <textarea name="info" id="info" placeholder="например: 1 подъезд, 3 этаж код домофона #6138" class="form-control"></textarea>
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <label for="info">Комментарий к заказу</label>
                            <textarea name="info" id="info" placeholder="например: позвонить по приезду" class="form-control"></textarea>
                        </div>
                        <div class="submit mt-3 w-100 d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-primary">Оформить заказ</button>
                        </div>
                    </div>
                </form>
            </div> 
        @endif
    </main>
    <hr>
    <x-footer/>
    <script src="http://cdn.jsdelivr.net/npm/suggestions-jquery@22.6.0/dist/js/jquery.suggestions.min.js"></script>
    <script>
        $("#address").suggestions({
            token: "b1fd6c9aee617244fe2e0e93a23ef9d28c72613d",
            type: "ADDRESS",
            onSelect: function(suggestion) {
                // console.log(suggestion);
            }
        });
    </script>
    <x-scripts/>
</body>