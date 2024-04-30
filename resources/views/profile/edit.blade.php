{{-- <x-app-layout> --}}
<x-head>
    <x-slot:title>
        Профиль
    </x-slot:title>
</x-head>
    <body>
        <header>
            <x-navbar/>
        </header>
    
        <main class="main-profile">
            <h2 class="container pt-3">Профиль</h2>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.adress')
                        </div>
                    </div>
        
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
        
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <hr>
        <footer>
            <x-footer/>
        </footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="http://cdn.jsdelivr.net/npm/suggestions-jquery@22.6.0/dist/js/jquery.suggestions.min.js"></script>

        <script>
            $("#address").suggestions({
                token: "b1fd6c9aee617244fe2e0e93a23ef9d28c72613d",
                type: "ADDRESS",
                onSelect: function(suggestion) {
                    // console.log(suggestion);
                }
            });
            // $(".address-input").each(function() {
            //     if ($(this).is(':disabled')) {
            //         $(this).next().on("click" function() {
            //             $(this).removeAttr('disabled');
            //             $(this).suggestions({
            //             token: "b1fd6c9aee617244fe2e0e93a23ef9d28c72613d",
            //             type: "ADDRESS",
            //             onSelect: function(suggestion) {
            //                 // console.log(suggestion);
            //             }
            //         });
            //         })
            //     }
            // });
        </script>
        <x-scripts/>
    </body>
{{-- </x-app-layout> --}}
