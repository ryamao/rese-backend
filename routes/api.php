<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthenticationStatusController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerFavoriteController;
use App\Http\Controllers\CustomerReservationController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ShopController;
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

Route::get('/areas', [AreaController::class, 'index']);
Route::get('/genres', [GenreController::class, 'index']);

Route::get('/shops', [ShopController::class, 'index']);

Route::get('/auth/status', [AuthenticationStatusController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customers/{user}', [CustomerController::class, 'show']);

    Route::post('/customers/{user}/shops/{shop}/favorite', [CustomerFavoriteController::class, 'store']);
    Route::delete('/customers/{user}/shops/{shop}/favorite', [CustomerFavoriteController::class, 'destroy']);

    Route::get('/customers/{user}/shops/{shop}/reservations', [CustomerReservationController::class, 'index']);
    Route::post('/customers/{customer}/shops/{shop}/reservations', [CustomerReservationController::class, 'store']);
});
