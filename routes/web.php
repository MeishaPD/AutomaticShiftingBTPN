<?php

use App\Http\Controllers\EmployeeOnboardingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Dashboard');
});

Route::get('/request-shifting', function () {
    return view('RequestShifting');
});

Route::get('/report', function () {
    return view('Report');
});

Route::get('/employee-onboarding', [EmployeeOnboardingController::class, 'index'])->name('employee.onboarding');
