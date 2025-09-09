<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('api', function ($request) {
    return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
});

// Routes untuk Web API (stateful)
Route::prefix('web')->group(function () {
    Route::post('/login', [AuthController::class, 'webLogin']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/registrations', [RegistrationController::class, 'store']);
        Route::get('/payments', [PaymentController::class, 'index']);
        Route::post('/payments', [PaymentController::class, 'store']);
    });
});

// Routes untuk Mobile API (stateless)
Route::prefix('mobile')->middleware(['throttle:api'])->group(function () {
    Route::post('/login', [AuthController::class, 'mobileLogin'])->middleware('throttle:5,1');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/registrations', [RegistrationController::class, 'store']);
        Route::get('/payments', [PaymentController::class, 'index']);
        Route::post('/payments', [PaymentController::class, 'store']);
        Route::get('/courses', [CourseController::class, 'index']);
    });
});
