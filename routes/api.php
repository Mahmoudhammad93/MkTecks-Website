<?php

use App\Http\Controllers\Api\AddressesController;
use App\Http\Controllers\Api\AppController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix'=>'v1', 'middleware'=>['cors']],function () {
    Route::get('home-banner', [AppController::class, 'homeBanner']);
    Route::get('settings', [AppController::class, 'settings']);
    Route::get('categories', [CategoriesController::class, 'index']);
    Route::get('categories/{id}', [CategoriesController::class, 'show']);
    Route::get('categories/{id}/products', [CategoriesController::class, 'categoryProducts']);
    Route::get('products', [ProductsController::class, 'index']);
    Route::get('products/{id}', [ProductsController::class, 'show']);
    Route::get('search', [ProductsController::class, 'search']);
    Route::post('register', [AuthController::class, 'register'])->name('api.user.register');
    Route::post('login', [AuthController::class, 'login'])->name('api.user.token');
    Route::get('cities', [AddressesController::class, 'cities']);
    Route::get('areas/{city_id}', [AddressesController::class, 'areas']);
    Route::get('/payment-success',[OrderController::class,'success'])->name('payment.success');
    Route::get('/payment-failed',[OrderController::class,'failed'])->name('payment.failed');
    Route::get('payment-methods', [AppController::class, 'paymentMethods']);
    Route::get('cart/as_guest', [CartController::class, 'cartAsGuest'])->name('api.cart.list');
    Route::get('cart/clear', [CartController::class, 'clear'])->name('api.cart.clear');
    Route::post('cart/add', [CartController::class, 'add'])->name('api.cart.add');
    Route::post('cart/update', [CartController::class, 'update'])->name('api.cart.update');
    Route::post('cart/remove', [CartController::class, 'remove'])->name('api.cart.remove');
    Route::get('branches', [AppController::class, 'branches'])->name('api.branches');
    Route::get('branches/{id}', [AppController::class, 'branch'])->name('api.branch');
    Route::post('submit-order-Asguest', [OrderController::class, 'submitOrderAsGuest'])->name('api.submit-order.asGuest');
    Route::post('orders/reorder-Asguest', [OrderController::class, 'reorderAsGuest'])->name('api.reorder');
    Route::post('applyCouponAsguest', [OrderController::class, 'getCoupon'])->name('applyCouponAsguest');
    Route::group(['middleware'=>['auth:sanctum']],function () {
        Route::get('profile', [UsersController::class, 'profile']);
        Route::post('profile/update', [UsersController::class, 'profileUpdate']);
        // Route::get('orders', [OrdersController::class, 'index']);
        Route::get('orders/history', [OrdersController::class, 'history']);
        Route::get('addresses', [AddressesController::class, 'index']);
        Route::post('addresses/create', [AddressesController::class, 'store']);
        Route::post('addresses/{id}/update', [AddressesController::class, 'update']);
        Route::delete('addresses/{id}/delete', [AddressesController::class, 'destroy']);

        Route::get('cart', [CartController::class, 'index'])->name('api.cart.list');
        Route::get('cart/clear', [CartController::class, 'clear'])->name('api.cart.clear');
        Route::post('cart/add', [CartController::class, 'add'])->name('api.cart.add');
        Route::post('cart/update', [CartController::class, 'update'])->name('api.cart.update');
        Route::post('cart/remove', [CartController::class, 'remove'])->name('api.cart.remove');
        
        
        Route::get('wishlist', [WishlistController::class, 'index'])->name('api.wishlist.list');
        Route::post('wishlist/add', [WishlistController::class, 'add'])->name('api.wishlist.add');
        Route::post('wishlist/remove', [WishlistController::class, 'remove'])->name('api.wishlist.remove');
        
        Route::get('checkout', [OrderController::class, 'checkout'])->name('api.checkout');
        Route::post('submit-order', [OrderController::class, 'submitOrder'])->name('api.submit-order');
        Route::get('orders', [OrderController::class, 'orders'])->name('api.orders');
        
        Route::get('orders/{order}', [OrderController::class, 'order'])->name('api.order');
        Route::post('orders/reorder', [OrderController::class, 'reorder'])->name('api.reorder');

        Route::delete('delete-account', [AuthController::class, 'deleteAccount'])->name('api.user.delete-account');

        Route::post('applyCoupon', [OrderController::class, 'applyCoupon'])->name('applyCoupon');
    });
});
