<?php

use App\Http\Middleware\VerifyCsrfToken;
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
Route::withoutMiddleware([VerifyCsrfToken::class])->group(function () {
    Route::get('auth/social/redirect/{provider}', [App\Http\Controllers\AuthController::class, 'socialLoginRedirect']);

    // Verify email
    Route::get('auth/verify/{token}', [App\Http\Controllers\AuthController::class, 'verifyEmail'])->name('verification.verify');
});
