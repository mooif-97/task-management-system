<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\API\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->apiResource("items", TaskController::class);
Route::middleware('auth:sanctum')->post('/items-by-pagination', [TaskController::class, 'index']);
Route::middleware('auth:sanctum')->post('/items', [TaskController::class, 'store']);
Route::middleware('auth:sanctum')->patch('/items', [TaskController::class, 'update']);

// user login and generate token
Route::post('/authenticate', [TokenController::class, 'authenticate']);
