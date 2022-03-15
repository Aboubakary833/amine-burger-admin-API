<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommandController;
use App\Http\Controllers\API\HomeController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('confirm', [AuthController::class, 'confirm']);
Route::post('password', [AuthController::class, 'password']);

Route::get('menu', [HomeController::class, 'menu']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('command', CommandController::class);
    Route::post('update', [AuthController::class, 'update']);
});