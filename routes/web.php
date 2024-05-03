<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;


// Route::get('/', 'Controller@home') ->name('home');
// Route::get('/about', 'Controller@about') ->name('about');

Route::get('/', function () {
    return view('home');
}) ->name('home');

Route::get('/about', [ProfileController::class, 'about'])->name('about');
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/promotion', [PromoteController::class, 'show'])->name('promote');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('addresses', AddressController::class);
});

require __DIR__.'/auth.php';

Route::get('/category/{slug}', function ($slug) {
    $category = Category::where('slug', $slug)->firstOrFail();
    $products = $category->products;
    $categoryName = $category->name;

    return view('category', ['products' => $products, 'categoryName' => $categoryName]);
})->name('category');

Route::get('/product/{slug}', function ($slug) {
    $product = Product::where('slug', $slug)->firstOrFail();
    return view('product', ['product' => $product]);
})->name('product');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
