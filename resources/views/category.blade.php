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
                    <div class="card border-0 d-flex flex-column text-decoration-none col-12 col-md-6 col-xl-4 my-2" data-id='{{$product->id}}' href="{{ route('product', ['slug' => $product->slug]) }}">
                        <a href="{{ route('product', ['slug' => $product->slug]) }}" class="card-img">
                            <img src="{{ asset("storage/$product->image") }}" alt="{{ $product->name }}" class="card-img">
                        </a>
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
                        <input type="hidden" id="unit_value" name="unitValue" value="{{ $product->unit->value }}">
                        <input type="hidden" id="unit_name" name="unitName" value="{{ $product->unit->name }}">
                        <hr>
                        <div class="card-description text-secondary">{{ $product->description }}</div>
                        <button class="btn btn-outline-success w-sm-25 w-50 my-3 add-cart" data-id='{{$product->id}}'>В корзину</button>
                        <div class="quantity-container my-3 d-flex d-none">
                            <button class="decrement btn btn-outline-success" data-id='{{$product->id}}'>-</button>
                            <span class="quantity btn btn-outline-success mx-2">
                                @if (isset($basket))
                                    @foreach ($basket as $item)
                                        @foreach ($item as $id => $quantity)
                                            @if ($id == $product->id)
                                                @php
                                                    $cardSum = $product->price * $quantity;
                                                    $sum = $sum + ($product->price * $quantity);
                                                    $unit = $product->unit->value * $quantity . $product->unit->name;
                                                @endphp
                                                <input type="hidden" id="quantity" name="{{ $product->id }}" value="{{ $quantity }}">
                                                <span class="unit">{{ $unit }}</span>
                                            @endif
                                            
                                        @endforeach
                                    @endforeach
                                @else
                                    <input type="hidden" id="quantity" value="0">
                                    <span class="unit">0</span>
                                @endif
                            </span>
                            <button class="increment btn btn-outline-success" data-id='{{$product->id}}'>+</button>
                        </div>
                        <div class="card-quantity d-none"></div>
                    </div>
                @endforeach 
                <div class="cart-total"></div>
            </div>
        </div>
    </main>
    <hr>
    <x-footer/>
    <x-scripts/>
</body>
