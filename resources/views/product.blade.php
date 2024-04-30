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
        <div class="product-info container">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <button class="btn btn-outline-success">В корзину | {{ $product->price }}Р</button>
        </div>
    </main>
    <hr>
    <x-footer/>
    <x-scripts/>
</body>
