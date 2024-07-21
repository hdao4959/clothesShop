<?php

use App\Events\OrderCreated;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
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




Route::middleware('notAdmin')->group(function(){
    // Trang chủ
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Trang chi tiết sản phẩm
    Route::prefix('/product')->as('product.')->group(function () {
        Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('detail');
    });

    // Danh mục
    Route::get('/category/{id}', [HomeController::class, 'showCategory'])->name('showCategory');
    // Giỏ hàng
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
    Route::post('handleCart', [CartController::class, 'handleCart'])->name('handleCart');
    // Xoá item trong giỏ hàng
    Route::delete('/cart/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    // Thanh toán
    Route::get("/form_order", [CartController::class, 'showFormOrder'])->name("form_order");
    Route::get("/form_buy_now", [CartController::class, 'showFormBuyNow'])->name("form_buy_now");
    Route::post('add_order', [OrderController::class, 'addOrder'])->name('add_order');
    Route::post('add_buy_now', [OrderController::class, 'addBuyNow'])->name('add_buy_now');

    //Trang thông tin tài khoản
    Route::get("/orders",[HomeController::class, 'account'])->name('client.orders')->middleware('auth');
    Route::get("/orderDetail/{id}",[HomeController::class, 'orderDetail'])->name('client.orderDetail')->middleware('auth');
    Route::post("/orderCanceled/{id}",[OrderController::class, 'orderCanceled'])->name('client.orderCanceled')->middleware('auth');
});

Auth::routes();

    Route::get("/loggin", function(){
        return view('login-register.login');
    });

