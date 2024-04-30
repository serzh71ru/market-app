<x-head>
    <x-slot:title>
    Главная
    </x-slot>
</x-head>
<body>
    <div class="page">
        <header>
            <x-navbar/>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/vegetables.jpg" class="d-block w-100" alt="Овощи">
                    </div>
                    <div class="carousel-item">
                        <img src="images/fruits.jpg" class="d-block w-100" alt="Фрукты">
                    </div>
                    <div class="carousel-item">
                        <img src="images/oils.jpg" class="d-block w-100" alt="Растительные масла">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </header>
        <main class="main">
            <div class="main-title mt-4">
                <h2>Добро пожаловать</h3>
            </div>
            <div class="categories container">
                <div class="row">
                    @foreach ($categories as $category)
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="col-12 col-md-6 col-xl-4 my-2 category-item">
                            <h3 class="category-item-title">{{ $category->name }}</h3>
                            <img class="category-item-img" src="{{ asset("storage/$category->image") }}" alt="{{ $category->name }}">
                        </a>
                    @endforeach
                    
                    
                </div>
            </div>
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A79a6091d7941693412651d7022aaabd5a188d043e7ef1931e4bc1bb9d87a102b&amp;width=100%25&amp;height=481&amp;lang=ru_RU&amp;scroll=true"></script>
        </main>
        <x-footer/>
    </div>
    <x-scripts/>
</body>
</html>