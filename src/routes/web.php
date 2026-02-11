<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MypageController;

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

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/search', [ProductController::class, 'search']);
Route::get('/item/{item_id}', [ProductController::class, 'detail'])->name('item.detail');
Route::post('/item/{item_id}/comment', [ProductController::class, 'storeComment'])->middleware('auth', 'verified')->name('item.comment.store');
Route::post('/item/{item_id}/like', [ProductController::class, 'toggleLike'])->middleware('auth', 'verified')->name('item.like.toggle');
Route::get('/sell', [ProductController::class, 'sell'])->middleware('auth', 'verified');
Route::post('/sell', [ProductController::class, 'storeProduct'])->middleware('auth', 'verified');

Route::get('/mypage', [MypageController::class, 'index'])->middleware('auth', 'verified')->name('mypage.index');
Route::get('/mypage/profile', [MypageController::class, 'profile'])->middleware('auth', 'verified')->name('mypage.profile');
Route::patch('/mypage/profile', [MypageController::class, 'update'])->middleware('auth', 'verified');

Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])->middleware('auth', 'verified')->name('purchase.index');
Route::post('/purchase/checkout/{item_id}', [PurchaseController::class, 'checkout'])->middleware('auth', 'verified')->name('purchase.checkout');
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address'])->middleware('auth', 'verified')->name('purchase.address');
Route::patch('/purchase/address/{item_id}', [PurchaseController::class, 'update'])->middleware('auth', 'verified')->name('purchase.address.update');
