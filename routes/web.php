<?php

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
