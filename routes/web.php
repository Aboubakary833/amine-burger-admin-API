<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function() {
    Route::get('/', [ProductsController::class, 'index'])->name('index');
    Route::resource('products', ProductsController::class);
    Route::resource('users', UserController::class);
    Route::resource('commands', CommandController::class);
});