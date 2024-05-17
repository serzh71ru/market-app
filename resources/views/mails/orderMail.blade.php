Заказ на доставку: 

Заказчик: {{ $userName }}
Email заказчика: {{ $userEmail }}
Телефон заказчика: {{ $userPhone }}
Адрес доставки: {{ $address }}
Комментарий к адресу доставки: {{ $addressInfo }}
Продукты в заказе:
    @foreach($products as $productName => $quantity)
    {{ $productName }} : @foreach ($productUnits as $name => $value)@if($name == $productName){{ $quantity * $value }} @switch($value)@case(0.5)кг@break @case(100)г @break @case(1)шт@break @default @endswitch @endif @endforeach 
    @endforeach

Если нет нужного товара: {{ $variant }}
Сумма заказа: {{ $sum }}
Комментарий к заказу: {{ $comment }}