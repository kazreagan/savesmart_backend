<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SavingGoalController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    // Add other user routes here
});

// Admin routes
Route::prefix('admin')->group(function () {
    // Admin login route (if you want a separate login page for admins)
    Route::get('/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'adminLogin'])->name('admin.login.submit');
    
    // Add the admin dashboard route here (accessible without admin middleware)
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Add the dashboard route inside the admin middleware group
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::resource('savingGoals', SavingGoalController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('notifications', NotificationController::class);
    Route::resource('users', UserController::class); // This will create admin.users.index, admin.users.create, etc.
    Route::resource('withdrawals', WithdrawalController::class);
    Route::resource('savings', SavingController::class);
    Route::resource('analytics', AnalyticsController::class);
    Route::resource('settings', SettingsController::class);
    Route::resource('categories', CategoryController::class);

});



Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');


