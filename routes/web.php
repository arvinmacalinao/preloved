<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductOwnerController;

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return view('welcome');
    }
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

Route::get('users', [UserController::class, 'index'])->name('user.lists');
Route::get('users/create', [UserController::class, 'create'])->name('new.user');

/* UserGroup*/
Route::get('usergroups', [UsergroupController::class, 'index'])->name('usergroup.lists');
Route::get('users/create', [UserController::class, 'create'])->name('new.user');

	// Route::resource('users', 'App\Http\Controllers\UserController', ['except' => ['show']])->name('users');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

/* Product */ 
Route::any('products', [ProductController::class, 'index'])->name('product.lists');
Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
Route::get('product/{id}/view', [ProductController::class, 'view'])->name('product.view');
Route::post('product/store/{id}', [ProductController::class, 'store'])->name('product.store');
Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::get('product/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
Route::get('product/download_barcode/{filename}', [ProductController::class, 'download'])->name('download.product.barcode');

/* Order */ 
Route::any('orders', [OrderController::class, 'index'])->name('order.lists');
Route::post('orders/store/', [OrderController::class, 'store'])->name('order.store');

Route::get('order/create', [OrderController::class, 'create'])->name('order.create');

Route::get('order/{id}/view', [OrderController::class, 'view'])->name('order.view');
Route::post('order/store/{id}', [OrderController::class, 'store'])->name('order.store');
Route::get('order/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
Route::get('order/delete/{id}', [OrderController::class, 'destroy'])->name('order.delete');


/* Product Type */ 
Route::get('product-types', [ProductTypeController::class, 'index'])->name('product.type.lists');
Route::get('product-types/create', [ProductTypeController::class, 'create'])->name('product.type.create');
Route::get('product-types/{id}/view', [ProductTypeController::class, 'view'])->name('product.type.view');
Route::post('product-types/store/{id}', [ProductTypeController::class, 'store'])->name('product.type.store');
Route::get('product-types/edit/{id}', [ProductTypeController::class, 'edit'])->name('product.type.edit');
Route::get('product-types/delete/{id}', [ProductTypeController::class, 'destroy'])->name('product.type.delete');

/* Product Owner */ 
Route::get('product-owner', [ProductOwnerController::class, 'index'])->name('product.owner.lists');
Route::get('product-owner/create', [ProductOwnerController::class, 'create'])->name('product.owner.create');
Route::post('product-owner/store/{id}', [ProductOwnerController::class, 'store'])->name('product.owner.store');
Route::get('product-owner/{id}/view', [ProductOwnerController::class, 'view'])->name('product.owner.view');
Route::get('product-owner/edit/{id}', [ProductOwnerController::class, 'edit'])->name('product.owner.edit');
Route::get('product-owner/delete/{id}', [ProductOwnerController::class, 'destroy'])->name('product.owner.delete');


});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

