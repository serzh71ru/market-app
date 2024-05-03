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
                @foreach ($products as $product)
                    <a class="card border-0 d-flex flex-column text-decoration-none col-12 col-md-6 col-xl-4 my-2" href="{{ route('product', ['slug' => $product->slug]) }}">
                        <img src="{{ asset("storage/$product->image") }}" alt="{{ $product->name }}" class="card-img">
                        <div class="d-flex justify-content-between  my-2">
                            <h4 class="card-title">{{ $product->name }}</h4>
                            <h4 class="card-price">{{ $product->price }} <span>Р</span></h4>
                        </div>
                        <hr>
                        <div class="card-description text-secondary">{{ $product->description }}</div>
                        <button class="btn btn-outline-success w-sm-25 w-50 my-3">В корзину</button>
                        <div class="quantity-container d-flex d-none">
                            <button class="decrement btn btn-success">-</button>
                            <span class="quantity btn btn-success">0</span>
                            <button class="increment btn btn-success">+</button>
                        </div>
                    </a>
                @endforeach 
                {{-- <x-card/>
                <x-card/>
                <x-card/>
                <x-card/>
                <x-card/>
                <x-card/>
                <x-card/>
                <x-card/> --}}
            </div>
        </div>
    </main>
    <hr>
    <x-footer/>
    <x-scripts/>
</body>
