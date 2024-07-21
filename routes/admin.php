<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
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


Route::prefix('admin')->as('admin.')
->middleware('isAdmin')
->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);

        Route::get('/orders', [OrderController::class, 'list'])->name('orders');
        Route::get('/orderDetail/{id}', [OrderController::class, 'orderDetail'])->name('order.detail');
        Route::post('/orderUpdate/{id}', [OrderController::class, 'orderUpdate'])->name('order.update');
});

