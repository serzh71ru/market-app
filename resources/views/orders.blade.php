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
            {{-- @dd($order) --}}
                <form action="{{ route('repeatOrder') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="order_type" value="{{ $order->getMorphClass() }}">
                    <div class="order_{{ $order->id }} border-1 border-success rounded-3 p-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <h4>Заказ от {{ Date::parse($order->created_at)->format('j F Y в H:i') }}</h4>
                            <span>Статус заказа: <h4 class="text-success">{{ $order->status }}</h4></span>
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
                                                    switch ($product->unit_id) {
                                                        case '1':
                                                            $productSum = ($order->status === 'Подтвержден' || $order->status === 'Выполнен') ? ($product->price * $product->quantity * 10) : ($product->price * $product->quantity);
                                                            break;
                                                        case '2':
                                                            $productSum = ($order->status === 'Подтвержден' || $order->status === 'Выполнен') ? ($product->price * $product->quantity) : ($product->price * $product->quantity * 0.5);
                                                            break;
                                                        case '3':
                                                            $productSum = $product->price * $product->quantity;
                                                            break;
                                                        
                                                        default:
                                                            echo('ОШИБКА: НЕИЗВЕСТНЫЕ ДАННЫЕ');
                                                            break;
                                                    }    
                                                    if ($order->status === 'Подтвержден' || $order->status === 'Выполнен'){
                                                        $unit = $product->quantity . $product->unit->name;
                                                    } else {
                                                        $unit = $product->unit->value * $product->quantity . $product->unit->name;
                                                    }                                       
                                                    $unit = $product->unit->value * $product->quantity . $product->unit->name;
                                                @endphp
                                                <input type="hidden" id="quantity" name="{{ $product->id }}" value="{{ ($order->status === 'Подтвержден' || $order->status === 'Выполнен') ? $product->quantity : ($product->quantity * $product->unit->value) }}">
                                                <span class="unit">{{ ($order->status === 'Подтвержден' || $order->status === 'Выполнен') ? $product->quantity . (($product->unit->name == 'г') ? 'кг' : $product->unit->name) : ($product->quantity * $product->unit->value) . $product->unit->name }}</span>
                                        </span>
                                    </div>
                                    <h4><span class="card-quantity">{{ $productSum }}</span>Р</h4>
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
                                <button type="submit" class="btn btn-primary"@if ($order->status === 'Создан' || $order->status === 'Оплачен')
                                    disabled @endif>Повторить заказ</button>
                        </div>
                    </div>
                </form>    
                    
                
            @endforeach
        </div>
    </main>
    <x-footer/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>