<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EngineController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SalespersonController;

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login and Logout Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// General Authenticated User Route Group
Route::middleware(['auth'])->group(function () {

    // Default Dashboard Route (Optional)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin Dashboard Routes
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Manager Dashboard Routes
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
    Route::put('/manager/engine/{id}/update-status', [ManagerController::class, 'updateStatus'])->name('manager.updateStatus');
    Route::get('/manager/generateReport', [ManagerController::class, 'generateReport'])->name('manager.generateReport');
// Routes for manager to search and correct engine status
Route::get('/manager/search-engine', [ManagerController::class, 'searchEngineBySerial'])->name('manager.searchEngine');
Route::put('/manager/correct-status/{id}', [ManagerController::class, 'correctStatus'])->name('manager.correctStatus');
Route::put('/manager/update-status/{id}', [ManagerController::class, 'updateStatusToUnsold'])->name('manager.updateStatusToUnsold');
    // Salesperson Dashboard Routes
    Route::get('/salesperson/dashboard', [SalespersonController::class, 'index'])->name('salesperson.dashboard');

    // Engine Routes for Searching and Updating
    Route::get('/engine/search', [EngineController::class, 'search'])->name('engine.search');
    Route::put('/engine/update/{id}', [EngineController::class, 'update'])->name('engine.update');
});

// Public Routes
Route::get('/', function () {
    return view('welcome');
});
