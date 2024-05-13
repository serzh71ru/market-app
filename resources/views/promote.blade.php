<x-head>
    <x-slot:title>
        Акции
    </x-slot>
</x-head>
<body>
    <header>
        <x-navbar/>
    </header>
    <main class="main-category">
        <div class="container">
            <h1 class="my-5 pt-3">Актуальные акции:</h1>
            <div class="row">
                @foreach ($promotions as $promote)
                <div class=" w-100 promote border-0 d-block d-md-flex flex-md-row text-decoration-none col-12 col-md-3 col-xl-2 my-2">
                    <img src="{{ asset("storage/$promote->image") }}" alt="{{ $promote->name }}" class="promote-img w-sm-100">
                    <div class="ms-md-5 pr-descript mt-3 mt-md-0">
                        <h4 class="card-title">{{ $promote->name }}</h4>
                        <p class="promote-description mt-4">
                            {{ $promote->description }}
                        </p>
                    </div>
                </div>
                <hr>
                @endforeach 
            </div>
        </div>
    </main>
    <hr>
    <x-footer/>
    <x-scripts/>
</body>