<x-head>
    <x-slot:title>
    Модерация заказов
    </x-slot>
</x-head>
<body>
    <header>
        
    </header>
    <main class="orders-main">
        @php
            use Illuminate\Support\Carbon;
            Carbon::setLocale('ru');
        @endphp
        <h3 class="py-5 ms-5 text-center">Список заказов:</h3>
        <div class="container">
            @foreach ($orders as $order)
            <form method="POST" action="{{ route('order.confirm') }}">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="order_type" value="{{ $order->getMorphClass() }}">
                <div class="order_{{ $order->id }} border-1 border-success rounded-3 p-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <h4>Заказ от {{ Date::parse($order->created_at)->format('j F Y в H:i') }}</h4>
                        <span>Заказчик: 
                            <h5>
                                @if ($order->getMorphClass() === "App\Models\UnregOrder")
                                    {{ $order->user_name }}
                                @else
                                    {{ $order->user->name }}
                                @endif
                                
                            </h5>
                        </span>
                        <span>Статус заказа: <h4 class="text-success">{{ $order->status }}</h4></span>
                    </div>
                    <div class="row mt-3">
                        <h5>Товары в заказе:</h5>
                    </div>
                    @php
                        $orderSum = 0;
                    @endphp
                    @foreach ($order->products as $product)
                        <div class=" w-100 card border-0 d-block d-md-flex flex-md-row text-decoration-none col-12 col-md-3 col-xl-2 my-2 justify-content-between align-items-center" data-id='{{$product->id}}'>
                            <h4 class="card-title">{{ $product->name }}</h4>
                            <div class="d-flex justify-content-between align-items-center  mx-lg-5">
                                <div class="quantity-container my-3 my-md-1 d-flex justify-content-center mx-md-5">
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
                                            $unit = $product->quantity;
                                        } else {
                                            $unit = $product->unit->value * $product->quantity;
                                        }     
                                        
                                        if ($order->status === 'Создан' || $order->status === 'Оплачен') {
                                            if ($product->unit_id == '1') {
                                            $unit = $unit / 1000;
                                            }
                                        }
                                    @endphp 
                                    <input type="number" step="0.001" class="form-control" name="weight_product_{{ $product->id }}" value="{{ $unit }}" @if ($order->status === 'Подтвержден' || $order->status === 'Выполнен')
                                        readonly="readonly"
                                    @endif/>
                                    <h6 class="mt-2 ms-2">{{ ($product->unit->name == 'г') ? 'кг' : $product->unit->name }}</h6>
                                </div>
                                <h4 class="mb-0"><span class="card-quantity">{{ $productSum }}</span>Р</h4>
                                @php
                                    $orderSum += $productSum;
                                @endphp
                                <a href="{{ route('confirmation.refresh', ['product_id' => $product->id, 'order_id' => $order->id, 'order_type' => $order->getMorphClass()]) }}" class="refresh ms-2" title="Заменить товар"><img src="{{ asset('images/refresh.jpg') }}" alt="refresh"></a>
                                <a href="{{ route('confirmation.product.delete', ['product_id' => $product->id, 'order_id' => $order->id, 'order_type' => $order->getMorphClass()]) }}" class="refresh ms-2" title="Удалить товар"><img src="{{ asset('images/delete.webp') }}" alt="refresh"></a>
                            </div>
                        </div>
                        <hr class="d-md-none">  
                    @endforeach
                    <div class="row mt-3">
                        <h5>Сумма заказа: {{ $orderSum }}р</h5>
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
                        <button type="submit" name="action" value="confirm" class="btn btn-primary" @if ($order->status === 'Подтвержден' || $order->status === 'Выполнен')
                            disabled>Заказ подтвержден
                        @else >Подтвердить заказ @endif</button>
                        <button type="submit" name="action" value="complete" class="btn btn-success" @if ($order->status === 'Подтвержден')
                            >Завершить заказ
                        @elseif ($order->status === 'Выполнен') disabled>Заказ выполнен @else disabled>Заказ не подтвержден @endif</button>
                        
                    </div>
                </div>
                
                    
            </form>  
            @endforeach
        </div>
    </main>

    <script>
        
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>