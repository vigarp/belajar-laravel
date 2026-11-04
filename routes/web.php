<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page.home');
});

Route::get('/profile', [MahasiswaController::class, 'index']);
Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
Route::get('/project/{id}', [ProjectController::class, 'show'])->name('project.show');

Route::get('/about', function () {
    return view('page.about');
});

// Route Login Admin
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');

// Fallback jika ada redirect ke route('login')
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// Route Admin (Wajib Login)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('/', function () {
        return view('admin.home');
    })->name('admin.dashboard');

    Route::resource('projects', AdminProjectController::class);
});
