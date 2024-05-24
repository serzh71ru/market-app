<x-head>
    <x-slot:title>
        Доставка и оплата
    </x-slot:title>
</x-head>
<body>
    <header>
        <x-navbar/>
    </header>
    <main>
        <div class="container delivery-container">
            <h1 class="my-3 pt-3">Доставка и оплата</h1>
            <div class="delivery-map">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A79a6091d7941693412651d7022aaabd5a188d043e7ef1931e4bc1bb9d87a102b&amp;width=100%25&amp;height=481&amp;lang=ru_RU&amp;scroll=true"></script>
                <div class="delivery-info h-100 p-4">
                    <h3 class="delivery-info-title">Доставка по Туле</h3>
                    <ul>
                        <li>Бесплатная доставка (минимальный заказ - 1500 ₽)</li>
                        <li>Время работы: 
                        <p class="ms-3 mt-3">Пн-Чт 10:00 - 22:00 <br>
                            Пт 10:00 - 23:00 <br>
                            Сб-Вс 11:00 - 23:00 </p>
                        </li>
                    </ul>
                    <h3 class="delivery-info-title">Оплата</h3>
                    <ul>
                        <li>Наличными курьеру</li>
                        <li>Картой курьеру</li>
                    </ul>
                </div>
            </div>
            
        </div>
    </main>
    <hr>
    <x-footer/>
    <x-scripts/>
</body>