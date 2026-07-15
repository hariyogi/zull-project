<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\staff\StaffController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Task\TaskStaffController;
use Illuminate\Support\Facades\Route;

// Redirect root to staff login by default or dashboard if logged in
Route::get('/', function () {
    return redirect()->route('login');
});

// Admin Login Routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'doLogin'])->name('login.post');

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['role:ADMIN'])->group(function () {
    // Manajemen Task
    Route::get('/task', [TaskController::class, 'index'])->name('task');
    Route::get('/task/report', [TaskController::class, 'showReport'])->name('task.report');
    Route::get('/task/create', [TaskController::class, 'showCreateTask'])->name('task.create');
    Route::post('/task/create', [TaskController::class, 'createTask'])->name('task.store');
    Route::get('/task/{taskId}/update', [TaskController::class, 'showUpdateTask'])->name('task.update');
    Route::post('/task/{taskId}/update', [TaskController::class, 'updateTask'])->name('task.update.store');
    Route::get('/task/detail/{taskId}', [TaskController::class, 'showDetailTask'])->name('task.detail');
    Route::get('/activity/{activity_task_id}/evidences', [TaskController::class, 'showEvidences'])->name('task.activity.evidences');
    Route::get('/task/download', [TaskController::class, 'downloadExcel'])->name('task.download');
    // Manajemen Staff
    Route::get('/staff', [StaffController::class, 'index'])->name('staff');
    Route::get('/staff/create', [StaffController::class, 'showCreateStaff'])->name('staff.create');
    Route::post('/staff/create', [StaffController::class, 'saveStaff'])->name('staff.store');
    Route::get('/staff/{staffId}/detail', [StaffController::class, 'showDetailStaff'])->name('staff.detail');
    Route::get('/staff/{staffId}/change-pass', [StaffController::class, 'showChangePasswordStaff'])->name('staff.change-pass');
    Route::post('/staff/{staffId}/change-pass', [StaffController::class, 'changePasswordStaff'])->name('staff.change-pass.store');
    Route::get('/staff/{staffId}/edit', [StaffController::class, 'showEditStaff'])->name('staff.edit');
    Route::post('/staff/{staffId}/edit', [StaffController::class, 'editStaff'])->name('staff.edit.store');
});

Route::middleware(['role:STAFF'])->group(function () {
    Route::get('/task/staff', [TaskStaffController::class, 'indexStaff'])->name('task.staff');
});

Route::middleware(['role:ADMIN,STAFF'])->group(function () {
    Route::get('/task/staff/{taskId}/report', [TaskStaffController::class, 'showReportStaff'])->name('task.staff.report');
    Route::post('/task/staff/{taskId}/report', [TaskStaffController::class, 'storeReportStaff'])->name('task.staff.report.store');
});
