<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenssegers\Date\Date;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->share('categories', Category::all());
        Date::setlocale(config('app.locale'));
    }
}
