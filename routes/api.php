<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\SavingGoalController;
use App\Http\Controllers\Api\WithdrawalController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SavingController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Test route for connection checking
Route::get('/user-test', function () {
    return response()->json([
        'user' => [
            'id' => 1,
            'name' => 'Sandra Nakawuka',
            'email' => 'nakawukasandra8@gmail.com',
            'district' => 'Kampala'
        ]
    ]);
});
Route::get('/test-connection', function () {
    return response()->json([
        'message' => 'Flutter-Laravel connection working!',
        'timestamp' => now(),
        'server' => 'Laravel on port 8001',
        'status' => 'success'
    ]);
});

// Public authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Get authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'data' => ['user' => $request->user()]
    ]);
});

// Logout route
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// API routes for your Flutter app
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Transaction routes
    Route::get('/transactions/recent', [TransactionController::class, 'recent']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/statistics', [TransactionController::class, 'statistics']);
    Route::post('/save', [TransactionController::class, 'apiSave']);
    Route::post('/withdraw', [TransactionController::class, 'apiWithdraw']);
    Route::post('/transfer', [TransactionController::class, 'apiTransfer']);
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::put('/transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

    // Saving goals routes
    Route::get('/savings/goals', [SavingGoalController::class, 'index']);
    Route::post('/savings/goals', [SavingGoalController::class, 'store']);
    Route::patch('/savings/goals/{id}/progress', [SavingGoalController::class, 'updateProgress']);
    Route::get('/savings/goals/summary', [SavingGoalController::class, 'summary']);
    Route::get('/savings/goals/{id}', [SavingGoalController::class, 'show']);
    Route::put('/savings/goals/{id}', [SavingGoalController::class, 'update']);
    Route::delete('/savings/goals/{id}', [SavingGoalController::class, 'destroy']);

    // Withdrawal routes
    Route::get('/withdrawals/recent', [WithdrawalController::class, 'recent']);
    Route::post('/withdrawals/request', [WithdrawalController::class, 'requestWithdrawal']);
    Route::patch('/withdrawals/{id}/process', [WithdrawalController::class, 'processWithdrawal']);
    Route::get('/withdrawals/statistics', [WithdrawalController::class, 'statistics']);
    Route::get('/withdrawals', [WithdrawalController::class, 'index']);
    Route::get('/withdrawals/{id}', [WithdrawalController::class, 'show']);

    // Users routes
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/users/active', [UserController::class, 'activeUsers']);
    Route::post('/users/status', [UserController::class, 'updateStatus']);

    // Categories routes
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Savings routes
    Route::get('/savings', [SavingController::class, 'index']);
    Route::post('/savings', [SavingController::class, 'store']);
    Route::get('/savings/{id}', [SavingController::class, 'show']);
    Route::put('/savings/{id}', [SavingController::class, 'update']);
    Route::get('/savings/summary', [SavingController::class, 'summary']);
    Route::get('/savings/analytics', [SavingController::class, 'analytics']);

    // Analytics routes
    Route::get('/analytics/overview', [AnalyticsController::class, 'overview']);
    Route::get('/analytics/transactions', [AnalyticsController::class, 'transactionsAnalytics']);
    Route::get('/analytics/savings', [AnalyticsController::class, 'savingsAnalytics']);
    Route::get('/analytics/users', [AnalyticsController::class, 'usersAnalytics']);
    Route::get('/analytics/categories', [AnalyticsController::class, 'categoriesAnalytics']);
    Route::get('/analytics/system-money-flow', [AnalyticsController::class, 'systemMoneyFlow']);

    // Settings routes
    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings', [SettingController::class, 'update']);
    Route::get('/settings/system', [SettingController::class, 'systemSettings']);
    Route::post('/settings/system', [SettingController::class, 'updateSystemSettings']);
    Route::get('/settings/analytics', [SettingController::class, 'analyticsSettings']);

    // Notifications routes
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
    Route::post('/notifications/send', [NotificationController::class, 'send']);
});

// Public endpoints without authentication
Route::prefix('v1')->group(function () {
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});
