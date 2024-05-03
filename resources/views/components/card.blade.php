<a class="card border-0 d-flex flex-column text-decoration-none col-12 col-md-6 col-xl-4 my-2" href="#">
    <img src="{{ $product->image }}" alt="{{ $product->name }}">
    <div class="d-flex justify-content-between  my-2">
        <h4 class="card-title">{{ $product->name }}</h4>
        <h4 class="card-price">{{ $product->price }} <span>Р</span></h4>
    </div>
    <hr>
    <div class="card-description text-secondary">{{ $product->description }}</div>
    <button class="btn btn-outline-success w-sm-25 w-50 my-3">В корзину</button>
    <div class="quantity-container">
        <div class="decrement"></div>
        <span class="quantity"></span>
        <div class="increment"></div>
    </div>
</a>