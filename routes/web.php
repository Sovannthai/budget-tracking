<?php

use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Admin\IncomeReportController;
use App\Http\Controllers\Admin\ExpenseReportController;
use App\Http\Controllers\BusinessSettingController;
use App\Http\Controllers\Frontend\BusinessSettingController as FrontendBusinessSettingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backends\RoleController;
use App\Http\Controllers\Backends\UserController;
use App\Http\Controllers\Backends\IncomeController;
use App\Http\Controllers\Backends\CustomerController;
use App\Http\Controllers\Backends\ExpenseController;
use App\Http\Controllers\Backends\IncomeTypeController;
use App\Http\Controllers\Backends\PermissionController;
use App\Http\Controllers\Backends\ExpenseTypeController;

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/home', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    // Budget
    Route::get('/budget',[BudgetController::class, 'index'])->name('budget.index');
    //Users 
    Route::resource('user', UserController::class);
    //Roles
    Route::resource('role', RoleController::class);
    //Permissions
    Route::resource('permission', PermissionController::class);
    //Customers
    Route::resource('customers',CustomerController::class);
    Route::post('/update-status', [CustomerController::class, 'updateStatus'])->name('update-status.customer');
    //Income Types
    Route::resource('income-types', IncomeTypeController::class);
    //Income
    Route::resource('incomes', IncomeController::class);
    //Expenses Types
    Route::resource('expense-types', ExpenseTypeController::class);
    //Expenses
    Route::resource('expenses', ExpenseController::class);
    //Reports 
    Route::get('/income-report', [IncomeReportController::class, 'index'])->name('income-report');
    Route::get('/expense-report', [ExpenseReportController::class, 'index'])->name('expense-report');
    
    // Business Settings
    Route::get('/business-settings', [BusinessSettingController::class, 'edit'])->name('business-settings.edit');
    Route::put('/business-settings', [BusinessSettingController::class, 'update'])->name('business-settings.update');
});

//Theme Dark Mode and Light Mode
Route::post('/admin/update-theme', [App\Http\Controllers\Admin\ThemeController::class, 'updateTheme'])->name('admin.update-theme');

// Frontend Routes
Route::get('/about-us', [FrontendBusinessSettingController::class, 'aboutUs'])->name('about-us');
Route::get('/terms-and-conditions', [FrontendBusinessSettingController::class, 'termsAndConditions'])->name('terms-and-conditions');
Route::get('/privacy-policy', [FrontendBusinessSettingController::class, 'privacyPolicy'])->name('privacy-policy');

Auth::routes();
