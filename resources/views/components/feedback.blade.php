<form action="/about/submit" method="POST" class="feedback mb-5">
    @csrf
    <div class="form-group">
        <label for="name" class="mt-2">Как вас зовут?</label>
        @if (auth()->check())
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        @else
            <input type="text" name="name" id="name" class="form-control" placeholder="Введите имя">
        @endif
        
        
        <label for="email" class="mt-2">Введите email:</label>
        @if (auth()->check())
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
        @else
            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
        @endif
        <label for="phone" class="mt-2">Введите номер телефона</label>
        @if (auth()->check())
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="username" />
        @else
            <input type="phone" name="phone" id="phone" class="form-control" placeholder="Телефон">
        @endif
        
        
        <label for="text" class="mt-2">Напишите сообщение</label>
        <textarea name="text" id="text" class="form-control" placeholder="Введите ваше сообщение"></textarea>
        <button type="submit" class="btn btn-outline-primary mt-2">Отправить сообщение</button>
    </div>
</form>
