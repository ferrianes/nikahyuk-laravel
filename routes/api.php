<?php

use Illuminate\Http\Request;
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

Route::middleware(['accept', 'localization'])->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('customer', \App\Http\Controllers\Api\ShowProfile::class);
        Route::put('customer', \App\Http\Controllers\Api\UpdateProfile::class);
        Route::get('logout', \App\Http\Controllers\Api\LogoutCustomer::class);
        Route::post('carts/{id_produk}', \App\Http\Controllers\Api\AddToCart::class);
        Route::get('carts', \App\Http\Controllers\Api\ShowCart::class);
        Route::delete('carts/{id}', \App\Http\Controllers\Api\RemoveCartItem::class);
        Route::get('carts/count', \App\Http\Controllers\Api\CountCart::class);
    });

    Route::post('login', \App\Http\Controllers\Api\LoginCustomer::class);
    Route::post('register', \App\Http\Controllers\Api\RegisterCustomer::class);
    Route::apiResource('products', \App\Http\Controllers\Api\ProductController::class);
});

Route::get('verify-email/{customer}/{token}', \App\Http\Controllers\Api\VerifyEmail::class)->where('token', '.*');
