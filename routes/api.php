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

Route::middleware('auth:sanctum')->group(function () {
});

Route::post('login', \App\Http\Controllers\Api\LoginCustomer::class);
Route::post('register', \App\Http\Controllers\Api\RegisterCustomer::class);
Route::get('verify-email/{customer}/{token}', \App\Http\Controllers\Api\VerifyEmail::class)->where('token', '.*');
Route::apiResource('products', \App\Http\Controllers\Api\ProductController::class);
