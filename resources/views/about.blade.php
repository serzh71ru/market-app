<x-head>
    <x-slot:title>
    Контакты
    </x-slot>
</x-head>
<body>
    <header>
        <x-navbar/>
    </header>
    <main class="container flex-column mt-5">
        <div class="row">
            <div class="col about pt-5">
                <h2 class="text-center">О нас</h2>
                <p class="my-4">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit provident magnam sit exercitationem necessitatibus quisquam ipsa! Porro repudiandae nam repellendus consequuntur voluptates, corrupti unde cum eaque delectus incidunt magnam eveniet ullam, laboriosam quam vel mollitia nihil. Iure numquam, eveniet mollitia debitis provident dolores commodi autem laudantium quisquam itaque veniam animi laborum velit impedit a fugit praesentium odit explicabo in vitae eligendi. In tempora minima quo quibusdam molestiae accusantium assumenda eos nulla necessitatibus iure culpa odit minus doloribus sit, magnam quas reiciendis vel ipsam perspiciatis. Nulla ea asperiores fugiat esse molestiae, corporis error sequi. Veniam cum fugit dignissimos non explicabo ullam. Laboriosam nesciunt nostrum voluptates. Possimus corrupti nemo dicta aspernatur voluptatem quaerat, reiciendis consectetur, ipsum mollitia fugiat excepturi deserunt consequatur quidem id earum? Dolor provident nostrum aperiam omnis magnam perspiciatis maxime quae exercitationem odio corrupti eaque cum quo culpa voluptatem sunt mollitia voluptate, dolore rem. Maxime nesciunt impedit adipisci hic necessitatibus dolores tenetur recusandae alias deserunt tempore animi quisquam provident, autem harum eum nemo facilis culpa unde possimus, ut aperiam? Alias blanditiis veniam voluptatum quis quasi quisquam dolorum pariatur minima voluptate officia repudiandae nostrum, laudantium vero quidem, hic incidunt quibusdam saepe eligendi sit placeat illo excepturi voluptatibus necessitatibus beatae. Accusamus error iusto autem at veritatis ipsa, ea excepturi dolorem corrupti molestias officia sapiente est eveniet tempora sint numquam! Minus ipsam non quod magni dolores iste voluptatum eius sunt fuga accusamus, sint expedita repellendus, pariatur voluptas maxime! Numquam sit sunt ab, impedit tempore, aut unde excepturi beatae eos fugiat in nobis alias.
                </p>
                <hr>
            </div>
        </div>
        
        
        <div class="row">
            <div class="col map my-5">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A79a6091d7941693412651d7022aaabd5a188d043e7ef1931e4bc1bb9d87a102b&amp;width=100%25&amp;height=481&amp;lang=ru_RU&amp;scroll=true"></script>
            </div>
        </div>
        <h3 class="text-center">Обратная связь</h3>
        <div class="row justify-content-center">
            <x-feedback :user="$user" />
        </div>
        <hr>
    </main>
    <x-footer/>
    <x-scripts/>
</body>