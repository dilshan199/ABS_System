<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OuathController;
use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('welcome');
})->middleware('checkOauth');

/**
 * Category routes
*/
Route::get('/category/create', [CategoryController::class, 'index'])->name('category.index')->middleware('checkOauth');
Route::post('/category/save', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/edit/{cat_id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update/{cat_id}', [CategoryController::class, 'update'])->name('category.update');
Route::get('/category/delete/{cat_id}', [CategoryController::class, 'destroy'])->name('category.destroy');

/**
 * Product routes
*/
Route::get('/product/insert', [ProductController::class, 'index'])->name('product.index')->middleware('checkOauth');
Route::post('/product/save', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/edit/{p_id}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/product/update/{p_id}', [ProductController::class, 'update'])->name('product.update');
Route::get('/product/delete/{p_id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/product/search', [ProductController::class, 'search'])->name('product.search');

/**
 * Oauth routes
 */
Route::get('/oauth/create', [OuathController::class, 'index'])->name('oauth.index');
Route::post('/oauth/save', [OuathController::class, 'store'])->name('oauth.store');
Route::get('/oauth/edit/{id}', [OuathController::class, 'edit'])->name('oauth.edit');
Route::post('/oauth/update/{id}', [OuathController::class, 'update'])->name('oauth.update');
Route::get('/oauth/delete/{id}', [OuathController::class, 'destroy'])->name('oauth.destory');
Route::get('/oauth/sign-in', function(){return view('oauth.login'); })->name('oauth.sign-in');
Route::post('/oauth/login', [OuathController::class, 'signIn'])->name('oauth.login');
Route::get('/oauth/sign-out', [OuathController::class, 'signOut'])->name('oauth.logout');
Route::get('/', [OuathController::class, 'home'])->name('welcome')->middleware('checkOauth');
