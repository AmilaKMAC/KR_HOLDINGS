<?php

use App\Http\Controllers\SystemMonitoring\SystemMonitoringController;
use App\Http\Controllers\SystemSettings\SystemSettingsController;
use App\Http\Controllers\UserManagement\UserManagementController;
use Illuminate\Support\Facades\Route;

// Sign In
Route::get('/', function () {
    return view('users.signin');
})->name('signin');

// Dashboards
Route::get('/dashboard', function () {
    return view('users.dashboard.admin');
})->name('admin.dashboard');
Route::get('/executive/dashboard', function () {
    return view('users.dashboard.executive');
})->name('executive.dashboard');
Route::get('/coordinator/dashboard', function () {
    return view('users.dashboard.coordinator');
})->name('coordinator.dashboard');
Route::get('/technician/dashboard', function () {
    return view('users.dashboard.technician');
})->name('technician.dashboard');

// User Management
Route::get('/userManagement', [UserManagementController::class, 'index'])->name('userManagement.index')->defaults('title', 'User Management');
Route::post('/userManagement/store', [UserManagementController::class, 'store'])->name('userManagement.store');
Route::put('/userManagement/update/{id}', [UserManagementController::class, 'update'])->name('userManagement.update');
Route::post('/userManagement/technician/store', [UserManagementController::class, 'storeTechnician'])->name('userManagement.storeTechnician');
Route::put('/userManagement/technician/update/{id}', [UserManagementController::class, 'updateTechnician'])->name('userManagement.updateTechnician');

// System Settings
Route::get('/system_settings', [SystemSettingsController::class, 'index'])->name('system_settings.index')->defaults('title', 'System Settings');
Route::post('/system_settings/technician_level', [SystemSettingsController::class, 'storeTechnicianLevel'])->name('system_settings.storeTechnicianLevel');
Route::put('/system_settings/technician_level/{id}', [SystemSettingsController::class, 'updateTechnicianLevel'])->name('system_settings.updateTechnicianLevel');
Route::post('/system_settings/solar_capacity', [SystemSettingsController::class, 'storeSolarCapacity'])->name('system_settings.storeSolarCapacity');
Route::put('/system_settings/solar_capacity/{id}', [SystemSettingsController::class, 'updateSolarCapacity'])->name('system_settings.updateSolarCapacity');
Route::post('/system_settings/additional_work', [SystemSettingsController::class, 'storeAdditionalWork'])->name('system_settings.storeAdditionalWork');
Route::put('/system_settings/additional_work/{id}', [SystemSettingsController::class, 'updateAdditionalWork'])->name('system_settings.updateAdditionalWork');
Route::post('/system_settings/partner_company', [SystemSettingsController::class, 'storePartnerCompany'])->name('system_settings.storePartnerCompany');
Route::put('/system_settings/partner_company/{id}', [SystemSettingsController::class, 'updatePartnerCompany'])->name('system_settings.updatePartnerCompany');

// System Monitoring
Route::get('/system_monitoring', [SystemMonitoringController::class, 'index'])->name('system_monitoring.index')->defaults('title', 'System Monitoring');

// Other Pages
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
Route::get('/attendance', function () {
    return view('users.components.attendance');
});
Route::get('/proof_of_work', function () {
    return view('users.components.proof_of_work');
});
Route::get('/profile', function () {
    return view('users.components.profile');
});
