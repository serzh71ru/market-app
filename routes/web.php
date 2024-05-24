<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

Route::post('/order', [OrderController::class, 'sendOrder'])->name('order');
Route::get('/orders', [OrderController::class, 'ordersStory'])->name('order_story');

Route::get('/', [BannerController::class, 'index'])->name('home');

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

Route::get('/category/{slug}', [CategoryController::class, 'showProducts'])->name('category');
Route::get('/delivery', function(){
    return view('delivery');
})->name('delivery');

Route::get('/product/{slug}', [ProductController::class, 'index'])->name('product');

Route::get('/basket', [CartController::class,'getBasket'])->name('cart');
Route::get('/basket/{id}', [CartController::class,'repeatOrder'])->name('repeatOrder');
Route::post('/setsession', [CartController::class,'setSession'])->name('set');
Route::get('/getsession', [CartController::class,'getsession'])->name('get');
Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class,'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class,'remove'])->name('cart.remove');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::post('sendFeedback', [FeedbackController::class, 'send']);