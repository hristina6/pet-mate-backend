<?php

use App\Http\Controllers\V1\BreedingRequestController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\PetController;
use App\Http\Controllers\V1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('pets', PetController::class)->only(['index', 'show', 'store', 'update']);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('posts', PostController::class);
Route::apiResource('breeding-requests', BreedingRequestController::class);
Route::get('/breeding-requests/{breedingRequest}/approve', [BreedingRequestController::class, 'approve']);
Route::get('/breeding-requests/{breedingRequest}/reject', [BreedingRequestController::class, 'reject']);
