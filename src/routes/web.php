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

Route::get('/', [ProductController::class, 'index']);
Route::get('/search', [ProductController::class, 'search']);
Route::get('/item/{item_id}', [ProductController::class, 'detail'])->name('item.detail');
Route::post('/item/{item_id}/comment', [ProductController::class, 'storeComment'])->name('item.comment.store');
Route::post('/item/{item_id}/like', [ProductController::class, 'toggleLike'])->name('item.like.toggle');
Route::post('/purchase/{item_id}', [PurchaseController::class, 'index'])->name('purchase.create');
Route::get('/mypage', [MypageController::class, 'index'])->middleware('auth')->name('mypage.index');
Route::get('/mypage/profile', [MypageController::class, 'profile'])->middleware('auth')->name('mypage.profile');
Route::patch('/mypage/profile', [MypageController::class, 'update'])->middleware('auth');
