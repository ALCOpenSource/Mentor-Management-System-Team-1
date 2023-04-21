<?php

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

// Auth endpoints
Route::prefix('auth')->group(function () {
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        // GET
        Route::get('user', [App\Http\Controllers\AuthController::class, 'user']);

        // POST
        Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
        Route::post('logout-all', [App\Http\Controllers\AuthController::class, 'logoutAll']);
        Route::post('logout-other', [App\Http\Controllers\AuthController::class, 'logoutOther']);
        Route::post('logout-device', [App\Http\Controllers\AuthController::class, 'logoutDevice']);
        Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    });

    // Add login with social media
    Route::prefix('social')->group(function () {
        Route::post('login', [App\Http\Controllers\AuthController::class, 'socialLogin']);
    });

    Route::prefix('password')->group(function () {
        Route::post('reset', [App\Http\Controllers\AuthController::class, 'resetPassword']);
    });
});

// Version 1
Route::prefix('v1')->group(function () {
    // Returns country list
    Route::get('countries', [App\Http\Controllers\CountryController::class, 'index']);

    // Returns country details including states and cities
    Route::get('countries/{country}/cities', [App\Http\Controllers\CountryController::class, 'getCities']);
    Route::get('countries/{country}/states', [App\Http\Controllers\CountryController::class, 'getStates']);

    // Returns state details including cities
    Route::get('states/{state}/cities', [App\Http\Controllers\CountryController::class, 'getStateCities']);
});
