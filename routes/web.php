<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Registration and login frontend
Route::view('/register', 'register');
Route::view('/login', 'login')->name('loginform');

// Registration and login backend
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');


// Dashboard and profile update
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/addresses', [DashboardController::class, 'addAddress'])->name('addAddress');
    Route::put('/addresses/{id}', [DashboardController::class, 'updateAddress'])->name('updateAddress');
});
