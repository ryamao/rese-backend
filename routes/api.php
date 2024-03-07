<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthenticationStatusController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerFavoriteController;
use App\Http\Controllers\CustomerReservationController;
use App\Http\Controllers\CustomerShopFavoriteController;
use App\Http\Controllers\CustomerShopReservationController;
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
Route::get('/shops/{shop}', [ShopController::class, 'show']);

Route::get('/auth/status', [AuthenticationStatusController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get(
        '/customers/{customer}',
        [CustomerController::class, 'show']
    );

    Route::get(
        '/customers/{customer}/favorites',
        [CustomerFavoriteController::class, 'index']
    );

    Route::post(
        '/customers/{customer}/shops/{shop}/favorite',
        [CustomerShopFavoriteController::class, 'store']
    );
    Route::delete(
        '/customers/{customer}/shops/{shop}/favorite',
        [CustomerShopFavoriteController::class, 'destroy']
    );

    Route::get(
        '/customers/{customer}/reservations',
        [CustomerReservationController::class, 'index']
    );
    Route::delete(
        '/customers/{customer}/reservations/{reservation}',
        [CustomerReservationController::class, 'destroy']
    );

    Route::get(
        '/customers/{customer}/shops/{shop}/reservations',
        [CustomerShopReservationController::class, 'index']
    );
    Route::post(
        '/customers/{customer}/shops/{shop}/reservations',
        [CustomerShopReservationController::class, 'store']
    );
});
