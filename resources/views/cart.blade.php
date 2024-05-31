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
            <form action="{{ route('payment.create') }}" method="POST" class="order-form mb-5 container">
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
                                    <input type="hidden" id="unit_value" name="unitValue" value="{{ $product->unit->value }}">
                                    <input type="hidden" id="unit_name" name="unitName" value="{{ $product->unit->name }}">
                                    <h4 class="d-none d-lg-block"><span class="card-price ms-5">{{ $product->price }}</span> <span>Р</span><span>/
                                        @switch($product->unit->name)
                                            @case('кг')
                                                кг
                                                @break
                                            @case('г')
                                                100г
                                                @break
                                            @case('шт')
                                                шт
                                                @break
                                            @default
                                                
                                        @endswitch        
                                    </span></h4>
                                    <div class="d-flex justify-content-between align-items-center  mx-lg-5">
                                        <div class="btn btn-outline-success w-sm-25 w-50 my-3 add-cart" data-id='{{$product->id}}'>В корзину</div>
                                        <div class="quantity-container my-3 my-md-1 d-flex d-none justify-content-center mx-md-5">
                                            <div class="decrement btn btn-outline-success" data-id='{{$product->id}}'>-</div>
                                            <span class="quantity btn btn-outline-success mx-2">
                                                @foreach ($basket as $item)
                                                    @foreach ($item as $id => $quantity)
                                                        @if ($id == $product->id)
                                                            @php
                                                                if($product->unit->value == 0.5){
                                                                    $cardSum = $product->price * $quantity * 0.5;
                                                                    $sum = $sum + $cardSum;
                                                                } else{
                                                                    $cardSum = $product->price * $quantity;
                                                                    $sum = $sum + ($product->price * $quantity);
                                                                }
                                                                
                                                                $unit = $product->unit->value * $quantity . $product->unit->name;
                                                            @endphp
                                                            <input type="hidden" id="quantity" name="{{ $product->id }}" value="{{ $quantity }}">
                                                            <span class="unit">{{ $unit }}</span>
                                                        @endif
                                                        
                                                    @endforeach
                                                @endforeach
                                            </span>
                                            <div class="increment btn btn-outline-success" data-id='{{$product->id}}'>+</div>
                                        </div>
                                        <h4><span class="card-quantity">{{ $cardSum }}</span>Р</h4>
                                    </div>
                                </div>
                                <hr class="d-md-none">
                            @endforeach
                            <hr>
                            <div class="total d-flex justify-content-between">
                                <h2>Итого:</h2>
                                <h2>
                                    <span class="cart-total">{{ $sum }}</span>
                                    <input type="hidden" name="sum" value="{{ $sum }}">
                                    <span>Р</span>
                                </h2>
                            </div>
                            <hr>
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
                        <div class="form-group w-100 mx-4">
                            <h4>Если выбранного товара не окажется в наличии:</h4>
                            <div >
                                <input type="radio" name="variant" id="call" value="Позвонить, подобрать замену если не отвечу">
                                <label for="call" class="ms-2">Позвонить, подобрать замену если не отвечу</label>
                            </div>
                            <div >
                                <input type="radio" name="variant" id="callDel" value="Позвонить, убрать товар если не отвечу">
                                <label for="callDel" class="ms-2">Позвонить, убрать товар если не отвечу</label>
                            </div>
                            <div>
                                <input type="radio" name="variant" id="replacement" value="Подобрать замену" checked>
                                <label for="replacement" class="ms-2">Подобрать замену</label>
                            </div>
                            <div>
                                <input type="radio" name="variant" id="exclude" value="Убрать товар">
                                <label for="exclude" class="ms-2">Убрать товар</label>
                            </div>
                        </div>
                        <div class="form-group mx-4 w-100">
                            @csrf
                            <div class="mt-4 mb-1">Выберите адрес доставки:</div>
                            @if ($user != NULL)
                                @foreach ($addresses as $address)
                                    <div class="d-flex align-items-center">
                                        <input type="radio" name="address" value="{{ $address->id }}" checked onclick="toggleRequired(this)">
                                        <input readonly="readonly" class="form-control ms-3" name="address_name" value="{{ $address->address }}">
                                    </div>                        
                                @endforeach
                            @endif
                            <div class="mt-2 d-flex align-items-center">
                                <input type="radio" class="mt-1 toggl" name="address" value="random-address" onclick="toggleRequired(this)" @if ($user == NULL) checked @endif>
                                <div class="w-100 ms-3">
                                    <input type="text" class="form-control mt-1 w-100" name="address_val" id="address" @if (isset($addresses) && count($addresses) == 0 || $user == NULL)
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
    <x-scriptsBasket/>
    <x-scripts/>
</body>