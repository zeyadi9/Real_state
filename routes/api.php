<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuditLogController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (requires Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Properties
    Route::get('/properties', [PropertyController::class, 'index']);
    Route::post('/properties', [PropertyController::class, 'store']);
    Route::get('/properties/sold', [PropertyController::class, 'sold']);
    Route::get('/properties/{id}', [PropertyController::class, 'show']);
    Route::post('/properties/{id}', [PropertyController::class, 'update']);
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);
    Route::post('/properties/{id}/sell', [PropertyController::class, 'markAsSold']);
    Route::post('/properties/{id}/available', [PropertyController::class, 'markAsAvailable']);
    Route::post('/properties/{id}/log', [PropertyController::class, 'addLog']);
    Route::get('/export-properties', [PropertyController::class, 'export']);
    Route::post('/import-properties', [PropertyController::class, 'import']);

    // Staff Users Management
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Audit logs
    Route::get('/audit-logs', [AuditLogController::class, 'index']);
});
