<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AdminAuthController::class, 'register']);
Route::post('/login', [AdminAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/user-list', [UserController::class, 'getData'])->name('list-users');
    Route::get('/users', [UserController::class, 'getData'])->name('users.index');
    Route::apiResource('users', UserController::class)->except(['index']);
});
