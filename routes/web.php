<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // API Routes for Members
    Route::get('/api/members', [MemberController::class, 'index']);
    Route::post('/api/members', [MemberController::class, 'store']);
    Route::get('/api/members/{member}', [MemberController::class, 'show']);
    Route::put('/api/members/{member}', [MemberController::class, 'update']);
    Route::delete('/api/members/{member}', [MemberController::class, 'destroy']);
});
