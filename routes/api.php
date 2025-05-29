<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\BreedingRequestController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\CommentController;
use App\Http\Controllers\V1\PetController;
use App\Http\Controllers\V1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User info route - authenticated
Route::middleware(['api', 'auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Public auth routes - no authentication required
Route::middleware('api')->prefix('/v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected API routes - require authentication
Route::middleware(['api', 'auth:sanctum'])->prefix('/v1')->group(function () {
    Route::apiResource('pets', PetController::class)->only(['index', 'show', 'store', 'update']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('categories.posts', PostController::class);
    Route::apiResource('categories.posts.comments', CommentController::class);
    Route::apiResource('breeding-requests', BreedingRequestController::class);
    Route::prefix('/breeding-requests/{breedingRequest}')->group(function () {
        Route::put('/approve', [BreedingRequestController::class, 'approve']);
        Route::put('/reject', [BreedingRequestController::class, 'reject']);
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});
