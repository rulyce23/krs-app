<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\StudentCourseApiController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\StudentDashboardController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\KRSValidationController;

// Public routes (no authentication required)
Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::prefix('auth')->group(function () {
        Route::post('student/login', [AuthController::class, 'studentLogin']);
        Route::post('student/register', [AuthController::class, 'studentRegister']);
        Route::post('admin/login', [AuthController::class, 'adminLogin']);
    });
});

// Protected routes (authentication required)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
     Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::apiResource('courses', CourseApiController::class);
    Route::apiResource('student-courses', StudentCourseApiController::class);

    // Route::prefix('notifications')->group(function () {
    //     Route::get('/', [NotificationController::class, 'index']);
    //     Route::get('unread-count', [NotificationController::class, 'unreadCount']);
    //     Route::post('{id}/read', [NotificationController::class, 'markAsRead']);
    //     Route::post('{id}/unread', [NotificationController::class, 'markAsUnread']);
    //     Route::post('mark-all-read', [NotificationController::class, 'markAllAsRead']);
    //     Route::delete('{id}', [NotificationController::class, 'destroy']);
    //     Route::post('/', [NotificationController::class, 'store']); // For testing
    // });
    Route::prefix('dashboard')->group(function () {
        Route::get('student', [StudentDashboardController::class, 'index']);
        Route::get('student/available-courses', [StudentDashboardController::class, 'availableCourses']);
        Route::get('admin', [AdminDashboardController::class, 'index']);
        Route::get('admin/students-attention', [AdminDashboardController::class, 'studentsRequiringAttention']);
    });
    Route::prefix('validation')->group(function () {
        Route::post('schedule-conflict', [KRSValidationController::class, 'validateScheduleConflict']);
        Route::post('credit-limit', [KRSValidationController::class, 'validateCreditLimit']);
        Route::post('prerequisites', [KRSValidationController::class, 'validatePrerequisites']);
        Route::post('quota-availability', [KRSValidationController::class, 'validateQuotaAvailability']);
        Route::post('krs', [KRSValidationController::class, 'validateKRS']);
    });
});