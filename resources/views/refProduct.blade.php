<x-head>
    <x-slot:title>
        {{ $categoryName }}
    </x-slot>
</x-head>
<body>
    <header>
        <x-navbar/>
    </header>
    <main class="main-category">
        <div class="container">
            <h1 class="my-3 pt-3">{{ $categoryName }}</h1>
            <div class="row">
                @php
                    $sum = 0;
                @endphp
                @foreach ($products as $product)
                    <div class="card border-0 d-flex flex-column text-decoration-none col-12 col-md-6 col-xl-4 my-2" data-id='{{$product->id}}'>
                        <div class="card-img">
                            <img src="{{ asset("storage/$product->image") }}" alt="{{ $product->name }}" class="card-img">
                        </div>
                        <div class="d-flex justify-content-between  my-2">
                            <h4 class="card-title">{{ $product->name }}</h4>
                            <h4><span class="card-price">{{ $product->price }}</span> <span>Р</span><span>/
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
                        </div>
                        <hr>
                        <div class="card-description text-secondary">{{ $product->description }}</div>
                        <form action="{{ route('refresh.confirm') }}" method="POST">
                            @csrf
                            <input type="hidden" name="refresh_product" value="{{ $product->id }}">
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="order_type" value="{{ $order->getMorphClass() }}">
                            <button class="btn btn-outline-success w-sm-25 w-50 my-3 add-cart">Выбрать</button>
                        </form>
                    </div>
                @endforeach 
                <div class="cart-total d-none"></div>
            </div>
        </div>
    </main>
    <hr>
    <x-footer/>
    <x-scripts/>
</body>