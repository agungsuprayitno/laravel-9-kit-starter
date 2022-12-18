<?php

use App\Auth\Controllers\AuthController;
use App\Products\Controllers\ProductController;
use App\Orders\Controllers\OrderController;
use App\Carts\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('signin', [AuthController::class, 'signIn']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('signout', [AuthController::class, 'signOut']);

    //  product
    Route::get('all-product', [ProductController::class, 'getAll']);
    Route::get('product', [ProductController::class, 'getPerPage']);
    Route::get('product/{productId}', [ProductController::class, 'getById']);
    Route::post('product', [ProductController::class, 'create']);
    Route::patch('product/{productId}', [ProductController::class, 'update']);
    Route::delete('product/{productId}', [ProductController::class, 'delete']);

    //  Order
    Route::get('all-order', [OrderController::class, 'getAll']);
    Route::get('order', [OrderController::class, 'getPerPage']);
    Route::get('order/{orderId}', [OrderController::class, 'getById']);
    Route::post('order', [OrderController::class, 'create']);

    //  cart
    Route::get('all-cart', [CartController::class, 'getAll']);
    Route::get('cart', [CartController::class, 'getPerPage']);
    Route::get('cart/{cartId}', [CartController::class, 'getById']);
    Route::post('cart', [CartController::class, 'create']);
    Route::patch('cart/{cartId}', [CartController::class, 'update']);
});
