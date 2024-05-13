<div class="nav d-flex justify-content-between align-items-center px-4">
    <nav class="d-none d-lg-inline-flex mt-2 mt-md-0 justify-content-center">
        <a class=" py-2 link-body-emphasis text-decoration-none nav-link"   href="{{ route('home') }}" >Главная</a>
        <a class=" py-2 link-body-emphasis text-decoration-none nav-link" href="{{ route('about') }}">Контакты</a>
        <a class=" py-2 link-body-emphasis text-decoration-none nav-link" href="{{ route('promote') }}">Акции</a>
        <div class="dropdown py-2">
            <a class="  link-body-emphasis text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Категории товаров
            </a>
          
            <ul class="dropdown-menu">
                @foreach ($categories as $category)
                  <li><a class="dropdown-item" href="{{ route('category', ['slug' => $category->slug]) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </nav>
    <nav class="navbar navbar-light bg-white p-0 fixed-start d-block d-lg-none">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 mb-3">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Главная</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('about') }}">Контакты</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Категории
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                    @foreach ($categories as $category)
                      <li><a class="dropdown-item" href="{{ route('category', ['slug' => $category->slug]) }}">{{ $category->name }}</a></li>
                    @endforeach
                  </ul>
                </li>
              </ul>
              <form action="{{ route('search') }}" class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Поиск" name="q">
                <button class="btn btn-outline-success" type="submit">Поиск</button>
              </form>
            </div>
          </div>
        </div>
    </nav>
    <div class="logo d-none d-sm-block">
        <h2>
            <a href="#" class="link-body-emphasis text-decoration-none">LOGO</a>
        </h2>
    </div>
    <div class="right-block d-flex align-items-center">
        <form action="{{ route('search') }}" class="d-none d-lg-block col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
            <input type="search" class="form-control" placeholder="Поиск..." aria-label="Поиск" name="q" >
        </form>
        @if (auth()->check())
            <x-acc-btn :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"/>
        @else
          <a href="{{ route('login') }}" class="btn btn-outline-primary me-2" type="submit">Вход</a>
          <a href="{{ route('register') }}" class="btn btn-outline-primary" type="submit">Регистрация</a>
        @endif
        <a href="{{ route('cart') }}" class="cart ms-3">
            <img src="{{ asset('images/cart.png') }}" alt="cart">
            <span class="cart-count d-none">0</span>
        </a>
    </div>
</div>