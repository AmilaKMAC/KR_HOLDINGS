<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('users.dashboard.admin');
});

Route::get('/user', function () {
    return view('users.components.user_management');
});


Route::get('/system_settings', function () {
    return view('users.components.system_settings');
});


Route::get('/system_monitoring', function () {
    return view('users.components.system_monitoring');
});



Route::get('/reports', function () {
    return view('users.components.reports');
});
