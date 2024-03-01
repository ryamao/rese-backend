<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthenticationStatusController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GenreController;
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

Route::get('/auth/status', [AuthenticationStatusController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customers/{user}', [CustomerController::class, 'show']);
});
