<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PastorProfileController;
use App\Http\Controllers\API\EducationController;
use App\Http\Controllers\API\WorkExperienceController;
use App\Http\Controllers\API\FollowController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\SermonController;
use App\Http\Controllers\API\PrayerRequestController;
use App\Http\Controllers\API\PrayerRequestReplyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Pastor Profile routes
    Route::get('/profile/my-profile', [PastorProfileController::class, 'myProfile']);
    Route::apiResource('profiles', PastorProfileController::class);

    // Education routes
    Route::apiResource('educations', EducationController::class);

    // Work Experience routes
    Route::apiResource('work-experiences', WorkExperienceController::class);

    // Follow routes
    Route::get('/pastors', [FollowController::class, 'pastors']);
    Route::post('/follow/{userId}', [FollowController::class, 'follow']);
    Route::delete('/unfollow/{userId}', [FollowController::class, 'unfollow']);
    Route::get('/followers', [FollowController::class, 'followers']);
    Route::get('/following', [FollowController::class, 'following']);

    // Message routes
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/conversations', [MessageController::class, 'conversations']);
    Route::get('/messages/conversation/{userId}', [MessageController::class, 'conversation']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::patch('/messages/{id}/read', [MessageController::class, 'markAsRead']);
    Route::get('/messages/unread-count', [MessageController::class, 'unreadCount']);

    // Sermon routes
    Route::get('/sermons/my-sermons', [SermonController::class, 'mySermons']);
    Route::apiResource('sermons', SermonController::class);

    // Prayer Request routes
    Route::get('/prayer-requests/my-requests', [PrayerRequestController::class, 'myPrayerRequests']);
    Route::patch('/prayer-requests/{id}/status', [PrayerRequestController::class, 'updateStatus']);
    Route::apiResource('prayer-requests', PrayerRequestController::class);

    // Prayer Request Reply routes
    Route::post('/prayer-requests/{prayerRequestId}/replies', [PrayerRequestReplyController::class, 'store']);
    Route::put('/prayer-request-replies/{id}', [PrayerRequestReplyController::class, 'update']);
    Route::delete('/prayer-request-replies/{id}', [PrayerRequestReplyController::class, 'destroy']);
});
