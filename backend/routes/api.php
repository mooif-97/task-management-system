<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\API\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->apiResource("items", TaskController::class);

// user login and generate token
Route::post('/authorize', [TokenController::class, 'authorize']);
