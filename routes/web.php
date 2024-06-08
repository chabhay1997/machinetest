<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('login/submit', [LoginController::class, 'login_submit'])->name('login_submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('register/submit', [LoginController::class, 'register_submit'])->name('register_submit');

Route::middleware(['auth'])->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('update', 'update_profile')->name('profile.update');
    });
});
