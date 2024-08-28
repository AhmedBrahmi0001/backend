<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlaceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/







{/*Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthenticationController::class, 'login']);
        Route::post('/refresh-token', [AuthenticationController::class, 'refreshToken'])->middleware('auth:sanctum');
        Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
        Route::post('/user', [AuthenticationController::class, 'user'])->middleware('auth:sanctum');
    });*/}
    Route::post('/adminlogin/login', [AuthenticationController::class, 'adminlogin']);
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::post('/auth/user', [AuthenticationController::class, 'user'])->middleware('auth:sanctum');

    Route::resource('clients', ClientController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('orders', OrderController::class);
    Route::post('send-order-position', [OrderController::class, 'sendOrderPosition']);
    Route::resource('notifications', NotificationController::class);
    Route::resource('evaluations', EvaluationController::class);
    Route::resource('complaints', ComplaintController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('places', PlaceController::class);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/weekly-statistics', [DashboardController::class, 'weeklyStatistics']);

    Route::get('categories/filter-by-price', [CategoryController::class, 'filterByPriceRange']);
    Route::put('notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::put('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);

