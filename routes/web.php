<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeOnboardingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestShiftingController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:employee|admin')->group(function () {
        Route::get('/request-shifting', [RequestShiftingController::class, 'index'])->name('request-shifting.index');
        Route::post('/request-shifting', [RequestShiftingController::class, 'store'])->name('request-shifting.store');

        Route::prefix('employee-onboarding')->group(function () {
            Route::get('/', [EmployeeOnboardingController::class, 'index'])->name('employee.onboarding');
        });
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::post('/report/download', [ReportController::class, 'download'])->name('report.download');

        Route::prefix('employee-onboarding')->group(function () {
            Route::get('/delete', [EmployeeOnboardingController::class, 'delete'])->name('employee.delete');
            Route::post('/remove', [EmployeeOnboardingController::class, 'remove'])->name('employee.remove');
        });
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
