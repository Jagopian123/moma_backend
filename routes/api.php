<?php

use App\Http\Controllers\Api\V1\AiController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\PremiumController;
use Illuminate\Support\Facades\Route;

// ── Health Check ────────────────────────────────────────────────
Route::get('/v1/health', [HealthController::class, 'check']);

// ── Auth Public ─────────────────────────────────────────────────
Route::prefix('v1/auth')->group(function () {
    Route::post('/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

// ── Protected ───────────────────────────────────────────────────
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::get('/me',          [AuthController::class, 'me']);
        Route::post('/logout',     [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    });

    // User
    Route::prefix('user')->group(function () {
        Route::get('/',    [UserController::class, 'show']);
        Route::put('/',    [UserController::class, 'update']);
        Route::delete('/', [UserController::class, 'destroy']);
    });

    // Premium
    Route::prefix('premium')->group(function () {
        Route::get('/status',    [PremiumController::class, 'status']);
        Route::get('/plans',     [PremiumController::class, 'plans']);
        Route::post('/activate', [PremiumController::class, 'activate']);
    });

    // AI
    Route::prefix('ai')->group(function () {
        Route::post('/parse-transaction', [AiController::class, 'parseTransaction']);
        Route::post('/scan-receipt',      [AiController::class, 'scanReceipt']);
    });
});