<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Add login with social media
Route::prefix('auth/social')->group(function () {
    Route::get('redirect/{provider}', [App\Http\Controllers\AuthController::class, 'socialLoginRedirect']);
    Route::get('callback/{provider}', [App\Http\Controllers\AuthController::class, 'socialLoginCallback']);
});
