<div class="dropdown text-end">
    <a href="#" class="d-block link-body-emphasis text-decoration-none " data-bs-toggle="dropdown" aria-expanded="false">
    <img src="{{ asset('images/acc.webp') }}" alt="account" width="32" height="32" class="rounded-circle">
    </a>
    <ul class="dropdown-menu text-small" style="">
    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Профиль</a></li>
    <li><a class="dropdown-item" href="{{ route('order_story') }}">История заказов</a></li>
    <li><a class="dropdown-item" href="{{ route('logout') }}">Выход</a></li>                          
    </ul>
</div>