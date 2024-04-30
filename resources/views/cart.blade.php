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
        
        <div class="container">
            <h2>Оформление заказа</h2>
            <div class="products row">
                <div class="card pt-2 d-flex flex-column text-decoration-none col-12 col-md-3 col-xl-2 my-2" href="#">
                    <img src="{{ asset("images/ananas.jpg") }}" alt="ananas" class="card-img">
                    <div class="d-flex justify-content-between  my-2">
                        <h4 class="card-title">Ананас</h4>
                        <h4 class="card-price">500 <span>Р</span></h4>
                    </div>
                    <hr>
                    <div class="btns d-flex">
                        <button class="btn btn-outline-success my-3">-</button>
                        <span class="btn btn-outline-success my-3">1</span>
                        <button class="btn btn-outline-success my-3">+</button>
                    </div>
                </div>
            </div>
            {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.adress')
                </div>
            </div> --}}
        </div>
    </main>
</body>