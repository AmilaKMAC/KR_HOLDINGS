<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Admin Dashboard Route
 *
 * Displays the admin dashboard page for authenticated users.
 *
 * @route GET /dashboard
 * @return \Illuminate\View\View The admin dashboard view
 */
// Route::get('/dashboard', function () {
//     return view('users.dashboard.admin');
// });



Route::get('/dashboard', function () {
    return view('users.dashboard.admin');
});

Route::get('/e', function () {
    return view('users.dashboard.executive');
});

Route::get('/c', function () {
    return view('users.dashboard.coordinator');
});

Route::get('/t', function () {
    return view('users.dashboard.technician');
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



Route::get('/tech', function () {
    return view('users.components.technician_performance');
});



Route::get('/payment', function () {
    return view('users.components.payment_and_salary');
});



Route::get('/review', function () {
    return view('users.components.review_photos');
});

Route::get('/demo', function () {
    return view('users.components.demo');
});


// Reports

Route::get('/reports', function () {
    return view('users.components.reports');
});


Route::get('/project_management', function () {
    return view('users.components.project_management');
});


Route::get('/attendance_approval', function () {
    return view('users.components.attendance_approval');
});


Route::get('/photo_approval', function () {
    return view('users.components.proof_of_work_review');
});

Route::get('/assign_projects', function () {
    return view('users.components.assign_projects');
});