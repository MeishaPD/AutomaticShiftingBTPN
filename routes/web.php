<?php

use App\Http\Controllers\EmployeeOnboardingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Dashboard');
})->name('dashboard');

Route::get('/request-shifting', function () {
    return view('RequestShifting');
});

Route::get('/report', function () {
    return view('Report');
});

Route::prefix('employee-onboarding')->group(function () {
    Route::get('/', [EmployeeOnboardingController::class, 'index'])->name('employee.onboarding');
    Route::get('/delete', [EmployeeOnboardingController::class, 'delete'])->name('employee.delete');
    Route::post('/remove', [EmployeeOnboardingController::class, 'remove'])->name('employee.remove');
});
