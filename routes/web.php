<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// --------------------
// Página principal redirige al login
// --------------------
Route::get('/', function () {
    return redirect()->route('login');
});

// --------------------
// Autenticación
// --------------------

// Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --------------------
// Dashboard del Profesor con Livewire
// --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/profesor/dashboard', \App\Livewire\ProfesorDashboard::class)
        ->name('profesor.dashboard');
});

// --------------------
// Dashboard del Alumno con Livewire
// --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/alumno/dashboard', \App\Livewire\Student\StudentDashboard::class)
        ->name('student.student-dashboard');
});

// --------------------
// Dashboard del Admin con Livewire
// --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});