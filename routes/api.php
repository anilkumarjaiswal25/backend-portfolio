<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ==========================
// 1️⃣ PUBLIC ROUTES (No Login)
// ==========================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// ==========================
// 2️⃣ AUTHENTICATED USER ROUTES
// ==========================
Route::middleware('auth:sanctum')->group(function () {

    // 🔐 Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // 👤 Logged-in user details
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // 📩 Contact form (Any logged-in user)
    Route::post('/contact', [ContactController::class, 'store']);
});


// ==========================
// 3️⃣ ADMIN ROUTES (Admin Only)
// ==========================
Route::middleware(['auth:sanctum', 'admin'])
    ->prefix('admin')
    ->group(function () {

        // 📩 Contact Messages
        Route::get('/messages', [AdminMessageController::class, 'index']);
        Route::get('/messages/{id}', [AdminMessageController::class, 'show']);
        Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy']);

        // 👥 Users Management
        Route::get('/users', [AdminUserController::class, 'index']);
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);
        //count user and message or contact message
        Route::get('/dashboard-stats', [AdminDashboardController::class, 'stats']);


    });

