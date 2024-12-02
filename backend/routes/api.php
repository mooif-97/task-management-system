<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\API\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->apiResource("items", TaskController::class);
Route::middleware('auth:sanctum')->post('/tasks-by-pagination', [TaskController::class, 'index']);
Route::middleware('auth:sanctum')->post('/tasks', [TaskController::class, 'store']);
Route::middleware('auth:sanctum')->put('/tasks/{tasks_id}', [TaskController::class, 'update']);

// user login and generate token
Route::post('/authenticate', [TokenController::class, 'authenticate']);
