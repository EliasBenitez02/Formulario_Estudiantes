<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard del alumno (Livewire)
Route::middleware(['auth'])->group(function () {
    Route::get('/alumno/dashboard', function () {
        return view('alumno.dashboard');
    })->name('alumno.dashboard');
});
