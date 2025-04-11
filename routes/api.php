<?php

use App\Http\Controllers\Api\AppApiController;
use Illuminate\Support\Facades\Route;

/**
 * API Routes
 *
 * Here is where you can register API routes for your application.
 * These routes are loaded by the RouteServiceProvider within a group which is assigned the "api" middleware group.
 * Now create something great!
 */
Route::middleware('api')
    ->prefix('v1')
    ->group(function () {
        //Customer Routes
        Route::post('/register', [AppApiController::class, 'register'])->name('api.register');
        Route::post('/login', [AppApiController::class, 'login'])->name('api.login');
        Route::post('/update-customer-info', [AppApiController::class, 'updateCustomerInfo'])->name('api.update-customer-info');
        Route::get('/get-customer-by-id',[AppApiController::class, 'getCustomerById'])->name('api.get-customer-by-id');
        Route::post('/update-password',[AppApiController::class, 'updatePassword'])->name('api.update-password');
        Route::post('/customer-send-email-verify', [AppApiController::class, 'sendOtp'])->name('api.send-email-verify');
        Route::post('/customer-verify-otp', [AppApiController::class, 'verifyOtp'])->name('api.verify-otp');
        Route::post('/set-new-password', [AppApiController::class, 'setNewPassword'])->name('api.set-new-password');

        //Income Types Routes
        Route::get('/income-type-by-customer',[AppApiController::class,'getIncomeTypeByCustomer'])->name('api.get-income-type-by-customer');
        Route::post('/create-income-type',[AppApiController::class,'createIncomeType'])->name('api.create-income-type');
        Route::post('/update-income-type',[AppApiController::class,'updateIncomeType'])->name('api.update-income-type');
        Route::delete('/delete-income-type',[AppApiController::class,'deleteIncomeType'])->name('api.delete-income-type');

        //Income Routes
        Route::get('/income-by-customer',[AppApiController::class,'getIncomeByCustomer'])->name('api.get-income-by-customer');
        Route::post('/create-income',[AppApiController::class,'createIncome'])->name('api.create-income');
        Route::post('/update-income',[AppApiController::class,'updateIncome'])->name('api.update-income');
        Route::delete('/delete-income',[AppApiController::class,'deleteIncome'])->name('api.delete-income');

        //Expense Types Routes
        Route::get('/expense-type-by-customer',[AppApiController::class,'getExpenseTypeByCustomer'])->name('api.get-expense-type-by-customer');
        Route::post('/create-expense-type',[AppApiController::class,'createExpenseType'])->name('api.create-expense-type');
        Route::post('/update-expense-type',[AppApiController::class,'updateExpenseType'])->name('api.update-expense-type');
        Route::delete('/delete-expense-type',[AppApiController::class,'deleteExpenseType'])->name('api.delete-expense-type');

        //Expense Routes
        Route::get('/expense-by-customer',[AppApiController::class,'getExpenseByCustomer'])->name('api.get-expense-by-customer');
        Route::post('/create-expense',[AppApiController::class,'createExpense'])->name('api.create-expense');
        Route::post('/update-expense',[AppApiController::class,'updateExpense'])->name('api.update-expense');
        Route::delete('/delete-expense',[AppApiController::class,'deleteExpense'])->name('api.delete-expense');
    });