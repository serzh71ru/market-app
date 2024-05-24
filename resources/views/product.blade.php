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
            <input type="hidden" id="unit_value" name="unitValue" value="{{ $product->unit->value }}">
            <input type="hidden" id="unit_name" name="unitName" value="{{ $product->unit->name }}">
            <button class="btn btn-outline-success add-cart" data-id='{{$product->id}}'>В корзину | <span class="product-price">{{ $product->price }}</span>Р<span>/
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
            </span></button>
            <div class="quantity-container my-3 d-flex d-none">
                <button class="decrement btn btn-outline-success" data-id='{{$product->id}}'>-</button>
                
                <span class="quantity btn btn-outline-success mx-2">
                    @if (isset($basket))
                        @foreach ($basket as $item)
                            @foreach ($item as $id => $quantity)
                                @if ($id == $product->id)
                                    @php
                                        $unit = $product->unit->value * $quantity . $product->unit->name;
                                    @endphp
                                    <input type="hidden" id="quantity" name="{{ $product->id }}" value="{{ $quantity }}">
                                    <span class="unit">{{ $unit }}</span>
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
    <x-scriptProduct/>
    <x-scripts/>
</body>
