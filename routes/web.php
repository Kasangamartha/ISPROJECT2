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

// Admin Dashboard Routes
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.createUser');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.storeUser');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.editUser');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.updateUser');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.deleteUser');
    Route::get('/admin/engines', [AdminController::class, 'showEngines'])->name('admin.engines');
    Route::get('/admin/engines/edit/{id}', [AdminController::class, 'editEngine'])->name('admin.editEngine');
    Route::put('/admin/engines/update/{id}', [AdminController::class, 'updateEngine'])->name('admin.updateEngine');
});

// General Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    // Default Dashboard Route (Optional)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Manager Dashboard Routes
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
    Route::put('/manager/engine/{id}/update-status', [ManagerController::class, 'updateStatus'])->name('manager.updateStatus');
    Route::get('/manager/generateReport', [ManagerController::class, 'generateReport'])->name('manager.generateReport');
    
    // Manager Routes for Searching and Correcting Engine Status
    Route::get('/manager/search-engine', [ManagerController::class, 'searchEngineBySerial'])->name('manager.searchEngine');
    Route::put('/manager/correct-status/{id}', [ManagerController::class, 'correctStatus'])->name('manager.correctStatus');
    Route::put('/manager/update-status/{id}', [ManagerController::class, 'updateStatusToUnsold'])->name('manager.updateStatusToUnsold');
    Route::middleware(['auth', 'role:manager'])->group(function () {
        Route::get('/manager/sales-table', [ManagerController::class, 'salesTable'])->name('manager.salesTable');
    });
    Route::get('/manager/sales', [ManagerController::class, 'salesTable'])
    ->name('manager.sales')
    ->middleware('auth', 'role:manager');

    // Salesperson Dashboard Routes
    Route::get('/salesperson/dashboard', [SalespersonController::class, 'index'])->name('salesperson.dashboard');
    Route::get('/salesperson/search-engines', [SalespersonController::class, 'searchByModelDisplacement'])->name('salesperson.searchByModelDisplacement');
// Search for engines by model, displacement, or serial number
Route::get('/salesperson/engines', [SalespersonController::class, 'searchByModelDisplacement'])->name('salesperson.engines');

// Mark an engine as sold
Route::post('/salesperson/engines/{id}/mark-as-sold', [SalespersonController::class, 'markAsSold'])->name('salesperson.engines.markAsSold');
Route::patch('/salesperson/engines/{id}/mark-as-sold', [EngineController::class, 'markAsSold'])
    ->name('salesperson.markAsSold');


    // Engine Routes for Searching and Updating
    Route::get('/engine/search', [EngineController::class, 'search'])->name('engine.search');
    Route::put('/engine/update/{id}', [EngineController::class, 'update'])->name('engine.update');

    Route::post('/ussd', [UssdController::class, 'handleUssdRequest']);


});

// Public Routes
Route::get('/', function () {
    return view('welcome');
});