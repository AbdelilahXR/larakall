<?php

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

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);


Route::middleware('auth:sanctum')->prefix('client')->group(function () {
    // log out
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/stores', [\App\Http\Controllers\Api\StoreController::class, 'index']);
    Route::get('/orders', [\App\Http\Controllers\Api\OrderController::class, 'index']);
    Route::get('/statistics', [\App\Http\Controllers\Api\OrderController::class, 'statistics']);
});
