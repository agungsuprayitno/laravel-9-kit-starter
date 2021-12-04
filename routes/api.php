<?php

use App\Auth\Controllers\AuthController;
use App\Menu\Controllers\MenuController;
use App\Order\Controllers\OrderController;
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

    //  Menu
    Route::get('all-menu', [MenuController::class, 'getAll']);
    Route::get('menu', [MenuController::class, 'getPerPage']);
    Route::get('menu/{menuId}', [MenuController::class, 'getById']);
    Route::post('menu', [MenuController::class, 'create']);
    Route::patch('menu/{menuId}', [MenuController::class, 'update']);
    Route::delete('menu/{menuId}', [MenuController::class, 'delete']);

    //  Order
    Route::get('all-order', [OrderController::class, 'getAll']);
    Route::get('order', [OrderController::class, 'getPerPage']);
    Route::get('order/{orderId}', [OrderController::class, 'getById']);
    Route::post('order', [OrderController::class, 'create']);
    Route::patch('order/{orderId}', [OrderController::class, 'update']);
    Route::delete('order/{orderId}', [OrderController::class, 'delete']);
});
