<x-head></x-head>
<body>
    <h2>Ваш баланс:</h2>
    <div>
        @if (cache()->has('balance')) 
            {{ cache()->get('balance') }}
        @else
            0    
        @endif
    </div>
    <h2>Пополнить баланс</h2>
    <br>
    <form method="post" action="{{ route('payment.create') }}">
        @csrf
        <input type="number" name="amount" placeholder="Введите сумму платежа">
        <input type="text" name="description" placeholder="Введите описание">
        <button type="submit">Перейти к оплате</button>

        <h2>Список транзакций</h2>
        <ol>
            @foreach ($transactions as $transaction)
                <li>{{ $transaction->amount }}  {{ $transaction->status }}</li>
            @endforeach
        </ol>
    </form>
</body>
</html>