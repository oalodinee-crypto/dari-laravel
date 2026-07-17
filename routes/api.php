<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =============================================
// مسارات React Admin Panel
// =============================================
Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::get('/user', [AdminController::class, 'user']);
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // المستخدمين
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/users/{id}', [AdminController::class, 'showUser']);
    Route::post('/users', [AdminController::class, 'createUser']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    
    // العقارات
    Route::get('/properties', [AdminController::class, 'properties']);
    Route::get('/properties/{id}', [AdminController::class, 'showProperty']);
    Route::post('/properties/{id}/approve', [AdminController::class, 'approveProperty']);
    Route::post('/properties/{id}/reject', [AdminController::class, 'rejectProperty']);
    
    // الحجوزات/العقود
    Route::get('/bookings', [AdminController::class, 'bookings']);
    Route::get('/bookings/{id}', [AdminController::class, 'showBooking']);
});

// =============================================
// مسارات المصادقة الأصلية (للتطبيق)
// =============================================
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});