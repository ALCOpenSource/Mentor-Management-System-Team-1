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

        // Change password
        Route::post('password/update', [App\Http\Controllers\AuthController::class, 'updatePassword']);
    });

    // Add login with social media
    Route::prefix('social')->group(function () {
        Route::post('login', [App\Http\Controllers\AuthController::class, 'socialLogin']);
        Route::get('redirect/{provider}', [App\Http\Controllers\AuthController::class, 'socialLoginRedirect']);
    });

    Route::prefix('password')->group(function () {
        Route::post('reset', [App\Http\Controllers\AuthController::class, 'resetPassword']);
        Route::post('change', [App\Http\Controllers\AuthController::class, 'changePassword']);

        // Check if token is valid
        Route::get('check/{token}', [App\Http\Controllers\AuthController::class, 'checkToken']);
    });
});

// Version 1
Route::prefix('v1')->group(function () {
    // Country endpoints
    Route::prefix('countries')->group(function () {
        // Returns country list
        Route::get('/', [App\Http\Controllers\CountryController::class, 'index']);

        // Returns country details including states and cities
        Route::get('{country}/cities', [App\Http\Controllers\CountryController::class, 'getCities']);
        Route::get('{country}/states', [App\Http\Controllers\CountryController::class, 'getStates']);

        // Returns state details including cities
        Route::get('states/{state}/cities', [App\Http\Controllers\CountryController::class, 'getStateCities']);
    });

    Route::middleware(['auth:sanctum', 'email.verified'])->group(function () {
        // User endpoints
        Route::prefix('user')->group(function () {
            // Get user data
            Route::get('/', [App\Http\Controllers\UserController::class, 'getUser']);

            // Update user profile
            Route::patch('/', [App\Http\Controllers\UserController::class, 'update']);

            // Get user preferences
            Route::get('preferences', [App\Http\Controllers\UserController::class, 'getPreferences']);

            // Update user preferences
            Route::patch('preferences', [App\Http\Controllers\UserController::class, 'updatePreferences']);

            // Update avatar
            Route::get('avatar/{filename}', [App\Http\Controllers\UserController::class, 'getAvatar'])->name('user.avatar');
            Route::post('avatar', [App\Http\Controllers\UserController::class, 'updateAvatar']);

            // Get avatar url only
            Route::get('avatar', [App\Http\Controllers\UserController::class, 'getAvatarUrl']);
        });

        // Support endpoints
        Route::prefix('support')->group(function () {
            // Get support data
            Route::get('/', [App\Http\Controllers\SupportController::class, 'getSupport']);

            // Get specific support data
            Route::get('{id}', [App\Http\Controllers\SupportController::class, 'getSpecificSupport']);

            // Get support image
            Route::get('image/{filename}', [App\Http\Controllers\SupportController::class, 'getSupportImage'])->name('support.image');

            // Update support data
            Route::post('/', [App\Http\Controllers\SupportController::class, 'createSupport']);
            Route::patch('{id}', [App\Http\Controllers\SupportController::class, 'updateSupport']);

            // Accept support ticket
            Route::post('accept/{id}', [App\Http\Controllers\SupportController::class, 'acceptSupport']);

            // Close support ticket
            Route::post('close/{id}', [App\Http\Controllers\SupportController::class, 'closeSupport']);

            // Open support ticket
            Route::post('open/{id}', [App\Http\Controllers\SupportController::class, 'openSupport']);

            // Assign ticket to user
            Route::post('assign/{id}', [App\Http\Controllers\SupportController::class, 'assignSupport']);

            // Delete support data
            Route::delete('{id}', [App\Http\Controllers\SupportController::class, 'deleteSupport']);

            // Delete all support data
            Route::delete('/', [App\Http\Controllers\SupportController::class, 'deleteAllSupport']);
        });

        // FAQ endpoints
        Route::prefix('faq')->group(function () {
            // Get faq data
            Route::get('/', [App\Http\Controllers\FaqsController::class, 'getFaqs']);

            // Update faq data
            Route::post('/', [App\Http\Controllers\FaqsController::class, 'createFaq']);
            Route::patch('{id}', [App\Http\Controllers\FaqsController::class, 'updateFaq']);

            // Delete faq data
            Route::delete('{id}', [App\Http\Controllers\FaqsController::class, 'deleteFaq']);
        });

        // Notification endpoints
        Route::prefix('notification')->group(function () {
            // Get notification data
            Route::get('/', [App\Http\Controllers\NotificationController::class, 'getNotifications']);

            // / Mark notification as read
            Route::post('read', [App\Http\Controllers\NotificationController::class, 'markAsRead']);

            // Delete notification data
            Route::delete('{id}', [App\Http\Controllers\NotificationController::class, 'deleteNotification']);
        });

        // Message endpoints
        Route::prefix('message')->group(function () {
            // Get message data
            Route::get('/', [App\Http\Controllers\MessageController::class, 'getMessage']);

            // Send message
            Route::post('/', [App\Http\Controllers\MessageController::class, 'sendMessage']);

            // Get overview of message threads
            Route::get('threads', [App\Http\Controllers\MessageController::class, 'getMessageThreads']);

            // Get message thread
            Route::get('thread/{reciever_id}', [App\Http\Controllers\MessageController::class, 'getMessageThread']);

            // Delete all message data
            Route::delete('thread/{reciever_id}', [App\Http\Controllers\MessageController::class, 'deleteAllMessagesInThread']);

            // Get message data
            Route::get('unread', [App\Http\Controllers\MessageController::class, 'getUnreadMessage']);

            // Mark message as read
            Route::post('read/{uuid}', [App\Http\Controllers\MessageController::class, 'markMessageAsRead']);

            // Mark message as unread
            Route::post('unread/{uuid}', [App\Http\Controllers\MessageController::class, 'markMessageAsUnread']);

            // Delete message data
            Route::delete('{uuid}', [App\Http\Controllers\MessageController::class, 'deleteMessage']);
        });

        // Post endpoints

        // Post discussions endpoints
    });
});
