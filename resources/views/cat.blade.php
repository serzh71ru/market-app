<div>
    @foreach ($categories as $cat)
    <li><a class="dropdown-item" href="">{{ $cat->name }}</a></li>
    @endforeach
</div>