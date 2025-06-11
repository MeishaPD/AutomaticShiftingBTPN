<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeOnboardingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestShiftingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/request-shifting', [RequestShiftingController::class, 'index'])->name('request-shifting.index');
Route::post('/request-shifting', [RequestShiftingController::class, 'store'])->name('request-shifting.store');

Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::post('/report/download', [ReportController::class, 'download'])->name('report.download');

Route::prefix('employee-onboarding')->group(function () {
    Route::get('/', [EmployeeOnboardingController::class, 'index'])->name('employee.onboarding');
    Route::get('/delete', [EmployeeOnboardingController::class, 'delete'])->name('employee.delete');
    Route::post('/remove', [EmployeeOnboardingController::class, 'remove'])->name('employee.remove');
});
