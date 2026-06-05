<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;

// Redirect root to staff login by default or dashboard if logged in
Route::get('/', function () {
    return redirect()->route('login.staff');
});

// Admin Login Routes
Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm'])->name('login.admin');
Route::post('/login/admin', [LoginController::class, 'loginAdmin']);

// Staff Login Routes
Route::get('/login/staff', [LoginController::class, 'showStaffLoginForm'])->name('login.staff');
Route::post('/login/staff', [LoginController::class, 'loginStaff']);

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Task Route
Route::get('/task', [TaskController::class, 'index'])->name('task');
Route::get('/task/create', [TaskController::class, 'showCreateTask'])->name('task.create');
Route::post('/cicing/store', [TaskController::class, 'createTask'])->name('task.store');
