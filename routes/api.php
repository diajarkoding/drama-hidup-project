<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

// ====================
// AUTH ROUTES (PUBLIC)
// ====================
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// ====================
// EMAIL VERIFICATION
// ====================
// public route but signed
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify')
    ->middleware('signed');

// ====================
// AUTH ROUTES (PROTECTED)
// ====================
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/email/resend', [VerificationController::class, 'resend']);
    // Route::get('/me', [UserController::class, 'profile']);
});
