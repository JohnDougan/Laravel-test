<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Временно, для верстки
//Artisan::call('view:clear');

Route::get('/', [Controller::class, 'getIndex'])->name('index');

Route::get('/login', [UsersController::class, 'getAuth'])->name('login');
Route::post('/login', [UsersController::class, 'actionAuth']);

Route::get('/logout', [UsersController::class, 'getLogout'])->middleware('auth');

Route::get('/register', [UsersController::class, 'getRegister'])->name('register');
Route::post('/register', [UsersController::class, 'actionRegister']);

Route::get('/orders', [TradeController::class, 'getOrders'])->name('orders')->middleware('auth');
Route::post('/orders/add', [TradeController::class, 'actionOrdersAdd'])->middleware('auth');

Route::get('/goods', [TradeController::class, 'getGoods'])->name('goods')->middleware('auth');
Route::post('/goods/add', [TradeController::class, 'actionGoodsAdd'])->middleware('auth');
