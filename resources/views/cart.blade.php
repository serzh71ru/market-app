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
        <div class="container"></div>
        <div class="form">
            <form action="/order" method="POST" class="order-form mb-5 container">
            @csrf
                <div class="container">
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
                                        <div class="btn btn-outline-success w-sm-25 w-50 my-3 add-cart" data-id='{{$product->id}}'>В корзину</div>
                                        <div class="quantity-container my-3 my-md-1 d-flex d-none justify-content-center mx-md-5">
                                            <div class="decrement btn btn-outline-success" data-id='{{$product->id}}'>-</div>
                                            <span class="quantity btn btn-outline-success mx-2">
                                                @foreach ($basket as $item)
                                                    @foreach ($item as $id => $quantity)
                                                        @if ($id == $product->id)
                                                            @php
                                                                $sum = $sum + ($product->price * $quantity);
                                                            @endphp
                                                            <input type="hidden" name="{{ $product->id }}" value="{{ $quantity }}">
                                                            {{ $quantity }}
                                                        @endif
                                                        
                                                    @endforeach
                                                @endforeach
                                            </span>
                                            <div class="increment btn btn-outline-success" data-id='{{$product->id}}'>+</div>
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
                    {{-- </div> --}}
                </div>
            
                <div class="order mt-5 d-flex flex-column align-items-center">
                    <h3 class="mb-5">Оформление заказа</h3>
                        <div class="form-group w-100">
                            <label for="name" class="mt-2">Ваше имя:</label>
                            @if (auth()->check())
                                <x-text-input id="name" name="user_name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                            @else
                                <input type="text" name="user_name" id="name" class="form-control" placeholder="Введите имя" required>
                            @endif
                            
                            
                            <label for="email" class="mt-2">Ваш email:</label>
                            @if (auth()->check())
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            @else
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                            @endif
                            <label for="phone" class="mt-2">Телефон для связи</label>
                            @if (auth()->check())
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="username" />
                            @else
                                <input type="phone" name="phone" id="phone" class="form-control" placeholder="Телефон" required>
                            @endif
                        </div>
                        <div class="form-group mx-4 w-100">
                            @csrf
                            {{-- @dd($addresses) --}}
                            <div class="mt-4 mb-1">Выберите адрес доставки:</div>
                            @if ($user != NULL)
                                @foreach ($addresses as $address)
                                    <div class="d-flex align-items-center">
                                        <input type="radio" name="address" value="{{ $address->id }}">
                                        <input readonly="readonly" class="form-control ms-3" name="address_name" value="{{ $address->address }}">
                                    </div>                        
                                @endforeach
                            @endif
                            <div class="mt-2 d-flex align-items-center">
                                <input type="radio" class="mt-1" name="address" value="random-address" checked>
                                <div class="w-100 ms-3">
                                    <input type="text" class="form-control mt-1 w-100" name="address_val" id="address" @if (isset($addresses) && count($addresses) == 0)
                                        required
                                    @endif>
                                </div>
                            </div> 
                            <div class="d-flex flex-column mt-3">
                                <label for="info-adress">Доп. информация об адресе доставки</label>
                                <textarea name="info_adress" id="info-adress" placeholder="например: 1 подъезд, 3 этаж код домофона #6138" class="form-control"></textarea>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <label for="info">Комментарий к заказу</label>
                                <textarea name="info" id="info" placeholder="например: позвонить по приезду" class="form-control"></textarea>
                            </div>
                            <div class="submit mt-3 w-100 d-flex justify-content-center">
                                <button type="submit" class="btn btn-outline-primary">Оформить заказ</button>
                            </div>
                        </div>
                </div>
            </form>
        </div>
        @else
            <div class="empty-cart border-2 rounded-3 py-3 px-3">
                <div class="card-body d-flex justify-content-between">
                    <h3 class="card-title">Корзина пуста</h3>
                    <a href="{{ route('home') }}" class="btn btn-success">В каталог</a>
                </div>
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