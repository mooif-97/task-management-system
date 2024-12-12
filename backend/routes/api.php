<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\API\TaskController;
use Illuminate\Support\Facades\RateLimiter;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->apiResource("items", TaskController::class);

Route::middleware('throttle:global')->group(function () {
    
    // Define your routes that should adhere to the global rate limit
    Route::middleware('auth:sanctum')->post('/tasks-by-pagination', [TaskController::class, 'index']);
    Route::middleware('auth:sanctum')->post('/tasks', [TaskController::class, 'store']);
    Route::middleware('auth:sanctum')->put('/tasks/{tasks_id}', [TaskController::class, 'update']);
    Route::middleware('auth:sanctum')->delete('/tasks/{tasks_id}', [TaskController::class, 'destroy']);
});

Route::middleware('throttle:auth')->group(function () {
    // user login and generate token
    Route::post('/authenticate', [TokenController::class, 'authenticate']);
    // Route::post('/login', [TokenController::class, 'authenticate']);
});

