<h2>Адреса доставки</h2>
<ul id="addresses" class="ps-0">
    @foreach ($addresses as $address)
        <li>
            <form action="{{ route('addresses.update', $address->id) }}" method="post" class="form-group">
                @csrf
                @method('patch')
                <input type="text" class="address-input form-control mt-3" value="{{ $address->address }}" disabled>
                <button class="btn btn-outline-primary d-inline-block edit-address mt-2">Редактировать</button>
                <button type="submit" class="btn btn-outline-success save-address d-none mt-2">Сохранить</button>
            </form>
            <form action="{{ route('addresses.destroy', $address->id) }}" method="post" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mt-2">Удалить</button>
            </form>
            
        </li>
    @endforeach
</ul>

<h2>Добавить новый адрес</h2>
<form action="{{ route('addresses.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="address">Адрес</label>
        <input type="text" class="form-control mt-3" name="address" id="address" required>
    </div>
    <x-primary-button class="mt-2">{{ __('Добавить') }}</x-primary-button>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-address');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const input = this.previousElementSibling;
                input.removeAttribute('disabled');
                input.focus();
                this.textContent = 'Save';
                this.classList.remove('edit-address');
                this.classList.add('save-address', 'd-none');
                this.nextElementSibling.classList.remove('d-none')
                input.dataset.id = this.dataset.id;
                input.dataset.originalValue = input.value;
            });
        });
    });
</script>