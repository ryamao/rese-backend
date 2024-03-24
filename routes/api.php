<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthenticationStatusController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerFavoriteController;
use App\Http\Controllers\CustomerReservationController;
use App\Http\Controllers\CustomerShopFavoriteController;
use App\Http\Controllers\CustomerShopReservationController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\NotificationEmailController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\OwnerShopController;
use App\Http\Controllers\OwnerShopReservationController;
use App\Http\Controllers\ReservationCheckinController;
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
    Route::post('/owners', [OwnerController::class, 'store'])
        ->middleware('permission:create owners');

    Route::post('/notification-email', [NotificationEmailController::class, 'store'])
        ->middleware('permission:send notification email');

    Route::get(
        '/customers/{customer}',
        [CustomerController::class, 'show']
    )
        ->middleware('permission:view customer infomation');

    Route::get(
        '/customers/{customer}/favorites',
        [CustomerFavoriteController::class, 'index']
    )
        ->middleware('permission:view favorites for customers');

    Route::post(
        '/customers/{customer}/shops/{shop}/favorite',
        [CustomerShopFavoriteController::class, 'store']
    )
        ->middleware('permission:add to favorites');
    Route::delete(
        '/customers/{customer}/shops/{shop}/favorite',
        [CustomerShopFavoriteController::class, 'destroy']
    )
        ->middleware('permission:remove from favorites');

    Route::get(
        '/customers/{customer}/reservations',
        [CustomerReservationController::class, 'index']
    )
        ->middleware('permission:view reservations for customers');
    Route::put(
        '/customers/{customer}/reservations/{reservation}',
        [CustomerReservationController::class, 'update']
    )
        ->middleware('permission:edit reservations');
    Route::delete(
        '/customers/{customer}/reservations/{reservation}',
        [CustomerReservationController::class, 'destroy']
    )
        ->middleware('permission:delete reservations');

    Route::get(
        '/customers/{customer}/shops/{shop}/reservations',
        [CustomerShopReservationController::class, 'index']
    )
        ->middleware('permission:view reservations for customers');
    Route::post(
        '/customers/{customer}/shops/{shop}/reservations',
        [CustomerShopReservationController::class, 'store']
    )
        ->middleware('permission:create reservations');

    Route::get('/owners/{owner}/shops', [OwnerShopController::class, 'index'])
        ->middleware('permission:view shops for owners');
    Route::post('/owners/{owner}/shops', [OwnerShopController::class, 'store'])
        ->middleware('permission:create shops');
    Route::put('/owners/{owner}/shops/{shop}', [OwnerShopController::class, 'update'])
        ->middleware('permission:edit shops');

    Route::get('/owners/{owner}/shops/{shop}/reservations', [OwnerShopReservationController::class, 'index'])
        ->middleware('permission:view reservations for owners');

    Route::get('/reservations/{reservation}/signed-url', [ReservationCheckinController::class, 'signedUrl'])
        ->middleware('permission:view reservations for customers');
    Route::post('/reservations/{reservation}/checkin', [ReservationCheckinController::class, 'checkin'])
        ->middleware('permission:view reservations for owners')
        ->name('reservation.checkin');
});
