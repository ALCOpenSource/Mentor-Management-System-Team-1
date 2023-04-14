<?php

use App\Models\User;
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

// Auth endpoints
Route::prefix('auth')->group(function () {
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
        Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
        Route::post('user', [App\Http\Controllers\AuthController::class, 'user']);
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
    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });
});
