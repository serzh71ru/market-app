<x-head>
    <x-slot:title>
    История заказов
    </x-slot>
</x-head>
<body>
    <header>
        <x-navbar/>
    </header>
    <main class="orders-main">
        @php
            use Illuminate\Support\Carbon;
            Carbon::setLocale('ru');
        @endphp
        <h3 class="py-5 ms-5 text-center">Ваши заказы:</h3>
        <div class="container">
            @foreach ($orders as $order)
                <div class="order_{{ $order->id }} border-1 border-success rounded-3 p-3 mb-3">
                    <div class="row">
                        <h4>Заказ от {{ Date::parse($order->created_at)->format('j F Y в H:i') }}</h4>
                    </div>
                    <div class="row mt-3">
                        <h5>Товары в заказе:</h5>
                    </div>
                    @foreach ($order->products as $product)
                        <div class=" w-100 card border-0 d-block d-md-flex flex-md-row text-decoration-none col-12 col-md-3 col-xl-2 my-2 justify-content-between align-items-center" data-id='{{$product->id}}'>
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
                                <div class="quantity-container my-3 my-md-1 d-flex justify-content-center mx-md-5">
                                    <span class="quantity btn btn-outline-success mx-2">
                                            @php
                                                if($product->unit->value == 0.5){
                                                    $cardSum = $product->price * $product->quantity * 0.5;
                                                } else{
                                                    $cardSum = $product->price * $product->quantity;
                                                }                                            
                                                $unit = $product->unit->value * $product->quantity . $product->unit->name;
                                            @endphp
                                            <input type="hidden" id="quantity" name="{{ $product->id }}" value="{{ $product->quantity }}">
                                            <span class="unit">{{ $unit }}</span>
                                    </span>
                                </div>
                                <h4><span class="card-quantity">{{ $cardSum }}</span>Р</h4>
                            </div>
                        </div>
                        <hr class="d-md-none">  
                    @endforeach
                    <div class="row mt-3">
                        <h5>Сумма заказа: {{ $order->sum }}р</h5>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <h5>Адрес доставки: {{ $order->user_address }}</h5>
                    </div>
                    @if ($order->user_address_info != '')
                        <div class="row mt-3">
                            <h5>Доп. информация по адресу доставки: {{ $order->user_address_info }}</h5>
                        </div>
                    @endif
                    <div class="mt-3">
                            <a href="{{ route('repeatOrder', ['id' => $order->id]) }}" class="btn btn-primary">Повторить заказ</a>
                    </div>
                </div>
                
                    
                
            @endforeach
        </div>
    </main>
    <x-footer/>
</body>