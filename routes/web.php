<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('users.dashboard.admin');
});

Route::get('/test', function () {
    return view('users.components.user_management');
});