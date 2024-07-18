<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
// Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::prefix('/product')->as('product.')->group(function () {
    Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('detail');
});

Route::get('/category/{id}', [HomeController::class, 'showCategory'])->name('showCategory');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
Route::get("/form_order", [CartController::class, 'showFormOrder'])->name("form_order");
Route::post('addCart', [CartController::class, 'addCart'])->name('addCart');

// Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

Route::post('add_order', [OrderController::class, 'addOrder'])->name('add_order');