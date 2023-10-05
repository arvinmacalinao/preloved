<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsergroupController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['guest'])->group(function() {
    /************************ START OF AUTHENTICATION ROUTES ************************/
    /* Login and Logout Routes */
    Route::get('login', [LoginController::class, 'loginform'])->name('users.loginform');
    Route::post('loginuser', [LoginController::class, 'login'])->name('users.login');

    /************************ END OF AUTHENTICATION ROUTES ************************/
});



Route::group(['middleware' => 'auth'], function () {

Route::any('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/home', [DashboardController::class, 'index'])->name('home');

/* Users */
Route::get('users', [UserController::class, 'index'])->name('user.lists');
Route::get('user/create', [UserController::class, 'create'])->name('new.user');
Route::post('user/store/{id}', [UserController::class, 'store'])->name('store.user');
Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::get('user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
Route::get('user/disable/{id}', [UserController::class, 'disable'])->name('user.disable');
Route::get('user/enable/{id}', [UserController::class, 'enable'])->name('user.enable');

/* UserGroup*/
Route::get('usergroups', [UsergroupController::class, 'index'])->name('usergroups.list');
Route::get('usergroup/create', [UsergroupController::class, 'create'])->name('usergroup.create');
Route::post('usergroup/store/{id}', [UsergroupController::class, 'store'])->name('usergroup.store');
Route::get('usergroup/edit/{id}', [UsergroupController::class, 'edit'])->name('usergroup.edit');
Route::get('usergroup/delete/{id}', [UsergroupController::class, 'delete'])->name('usergroup.delete');
// Route::get('usergroup/disable/{id}', [UsergroupController::class, 'disable'])->name('user.disable');
// Route::get('usergroup/enable/{id}', [UsergroupController::class, 'enable'])->name('user.enable');



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
Route::get('/get-product-details-by-barcode', [OrderController::class, 'getProductDetailsByBarcode'])->name('get-product-details-by-barcode');
Route::get('/get-product-suggestions', [OrderController::class, 'getProductSuggestions'])->name('get-product-suggestions');

/* Sales */ 
Route::any('sales', [SalesController::class, 'index'])->name('sales.list');

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

// Route::group(['middleware' => 'auth'], function () {
// 	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
// });

