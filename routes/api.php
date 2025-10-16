<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SettingsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('/send-otp',  'sendOtp');
    Route::post('/verify-otp',  'verifyOtp');
    Route::post('/register',  'register');
});
Route::middleware('auth:sanctum')->group(function () {
    //Profile && Logout
    Route::controller(AuthController::class)->group(function () {
        Route::get('/profile', 'profile');
        Route::post('/update-profile', 'updateProfile');
        Route::post('/logout', 'logout');
    });
    // Courses
    Route::controller(CourseController::class)->prefix('courses')->group(function () {
        Route::get('/index', 'index');
        Route::get('/show/{id}', 'show');
    });
    // enrollments
    Route::controller(EnrollmentController::class)->prefix('enrollments')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        // Route::post('/apply-coupone', 'applyCoupone');
    });
    // Favorites
    Route::controller(FavoriteController::class)->prefix('favorites')->group(function () {
        Route::get('/', 'index');
        Route::post('/toggle', 'toggle');
    });
    // Reviews
    Route::controller(ReviewController::class)->prefix('reviews')->group(function () {
        Route::post('/store', 'store');
        Route::post('/delete/{id}', 'destroy');
    });
    //Settings
    Route::get('/settings', [SettingsController::class, 'index']);
    //chats
    Route::controller(MessageController::class)->prefix('chat')->group(function () {
        Route::get('/conversations', 'getUserConversations');
        Route::get('/unread-conversations', 'unreadConversationsCount');
        Route::post('/messages/send', 'sendMessage');
        Route::post('/mark-as-read/{conversationId}', 'markAsRead');
        Route::get('/messages/{conversationId}', 'messages');
    });
});
