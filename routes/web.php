<?php
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\SystemMonitoring\SystemMonitoringController;
use App\Http\Controllers\SystemSettings\SystemSettingsController;
use App\Http\Controllers\TechnicianPerformance\TechnicianPerformanceController;
use App\Http\Controllers\UserManagement\UserManagementController;
use App\Http\Controllers\PaymentAndSalary\PaymentAndSalaryController;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\ProjectManagement\ProjectManagementController;
use App\Http\Controllers\Attendance\AttendanceApprovalController;
use App\Http\Controllers\Proof\WorkApprovalController;
use App\Http\Controllers\Proof\WorkReviewController;
use App\Http\Controllers\ProjectManagement\AssignProjectController;
use App\Http\Controllers\Attendance\AttendanceMarkController;
use App\Http\Controllers\Dashboard\ExecutiveController;
use App\Http\Controllers\Dashboard\CoordinatorController;
use App\Http\Controllers\Dashboard\TechnicianController;
use App\Http\Controllers\Proof\ImageUploadController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

// Sign In
Route::get('/', function () {
    return view('users.signin');
})->name('signin');

// Dashboards
Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->defaults('title', 'Dashboard');

Route::get('/e', [ExecutiveController::class, 'index'])->name('executive.dashboard')->defaults('title', 'Dashboard');

Route::get('/c', [CoordinatorController::class, 'index'])->name('coordinator.dashboard')->defaults('title', 'Dashboard');

Route::get('/t', [TechnicianController::class, 'index'])->name('technician.dashboard')->defaults('title', 'Dashboard');




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

// Technician Performance
Route::get('/tech', [TechnicianPerformanceController::class, 'index'])->name('technician_performance.index')->defaults('title', 'Technician Performance');


// Payment and Salary
Route::get('/payment', [PaymentAndSalaryController::class, 'index'])->name('payment_and_salary.index')->defaults('title', 'Payment and Salary');

// Review Photos
Route::get('/review', [WorkReviewController::class, 'index'])->name('review_photos.index')->defaults('title', 'Review Photos');

// Demo
Route::get('/demo', [DemoController::class, 'index'])->name('demo.index')->defaults('title', 'Demo');

// Reports
Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index')->defaults('title', 'Reports');


// Project Management
Route::get('/project_management', [ProjectManagementController::class, 'index'])->name('project_management.index')->defaults('title', 'Project Management');

// Attendance Approval
Route::get('/attendance_approval', [AttendanceApprovalController::class, 'index'])->name('attendance_approval.index')->defaults('title', 'Attendance Approval');

// Photo Approval
Route::get('/proof_of_work_approval', [WorkApprovalController::class, 'index'])->name('proof_of_work_approval.index')->defaults('title', 'Proof of Work Approval');


// Asign Projects
Route::get('/assign_projects', [AssignProjectController::class, 'index'])->name('assign_projects.index')->defaults('title', 'Assign Projects');


// Attendance Mark
Route::get('/attendance', [AttendanceMarkController::class, 'index'])->name('attendance.index')->defaults('title', 'Attendance');


// Proof of work
Route::get('/proof_of_work', [ImageUploadController::class, 'index'])->name('proof_of_work.index')->defaults('title', 'Image Upload');

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->defaults('title', 'Profile');
