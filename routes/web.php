<?php

use App\Http\Controllers\Attendance\AttendanceApprovalController;
use App\Http\Controllers\Attendance\AttendanceMarkController;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\CoordinatorController;
use App\Http\Controllers\Dashboard\ExecutiveController;
use App\Http\Controllers\Dashboard\TechnicianController;
use App\Http\Controllers\PaymentAndSalary\PaymentAndSalaryController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\ProjectManagement\AssignProjectController;
use App\Http\Controllers\ProjectManagement\ProjectManagementController;
use App\Http\Controllers\Proof\ImageUploadController;
use App\Http\Controllers\Proof\WorkApprovalController;
use App\Http\Controllers\Proof\WorkReviewController;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\SystemMonitoring\SystemMonitoringController;
use App\Http\Controllers\SystemSettings\SystemSettingsController;
use App\Http\Controllers\TechnicianPerformance\TechnicianPerformanceController;
use App\Http\Controllers\ProjectManagement\AssignTechnicianController;
use App\Http\Controllers\UserManagement\UserManagementController;
use App\Http\Controllers\Reports\LogController;
use Illuminate\Support\Facades\Route;

// ================= PUBLIC =================
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= ADMIN (role: 1) =================
// role_id 1 = Admin
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->defaults('title', 'Dashboard');
    Route::get('/userManagement', [UserManagementController::class, 'index'])->name('userManagement.index')->defaults('title', 'User Management');
    Route::post('/userManagement/store', [UserManagementController::class, 'store'])->name('userManagement.store');
    Route::put('/userManagement/update/{id}', [UserManagementController::class, 'update'])->name('userManagement.update');
    Route::post('/userManagement/technician/store', [UserManagementController::class, 'storeTechnician'])->name('userManagement.storeTechnician');
    Route::put('/userManagement/technician/update/{id}', [UserManagementController::class, 'updateTechnician'])->name('userManagement.updateTechnician');
    Route::get('/system_settings', [SystemSettingsController::class, 'index'])->name('system_settings.index')->defaults('title', 'System Settings');
    Route::post('/system_settings/technician_level', [SystemSettingsController::class, 'storeTechnicianLevel'])->name('system_settings.storeTechnicianLevel');
    Route::put('/system_settings/technician_level/{id}', [SystemSettingsController::class, 'updateTechnicianLevel'])->name('system_settings.updateTechnicianLevel');
    Route::post('/system_settings/solar_capacity', [SystemSettingsController::class, 'storeSolarCapacity'])->name('system_settings.storeSolarCapacity');
    Route::put('/system_settings/solar_capacity/{id}', [SystemSettingsController::class, 'updateSolarCapacity'])->name('system_settings.updateSolarCapacity');
    Route::post('/system_settings/additional_work', [SystemSettingsController::class, 'storeAdditionalWork'])->name('system_settings.storeAdditionalWork');
    Route::put('/system_settings/additional_work/{id}', [SystemSettingsController::class, 'updateAdditionalWork'])->name('system_settings.updateAdditionalWork');
    Route::post('/system_settings/partner_company', [SystemSettingsController::class, 'storePartnerCompany'])->name('system_settings.storePartnerCompany');
    Route::put('/system_settings/partner_company/{id}', [SystemSettingsController::class, 'updatePartnerCompany'])->name('system_settings.updatePartnerCompany');
    Route::get('/system_monitoring', [SystemMonitoringController::class, 'index'])->name('system_monitoring.index')->defaults('title', 'System Monitoring');
    Route::post('/force-logout/{id}', [SystemMonitoringController::class, 'forceLogout'])->name('system_monitoring.forceLogout');
    Route::get('/log_reports', [LogController::class, 'index'])->name('log_reports.index')->defaults('title', 'Log Reports');
});

// ================= EXECUTIVE (role: 2) =================
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/executive', [ExecutiveController::class, 'index'])->name('executive.dashboard')->defaults('title', 'Dashboard');
    Route::get('/technician_performance', [TechnicianPerformanceController::class, 'index'])->name('technician_performance.index')->defaults('title', 'Technician Performance');
    Route::get('/payment', [PaymentAndSalaryController::class, 'index'])->name('payment_and_salary.index')->defaults('title', 'Payment and Salary');
    Route::get('/review', [WorkReviewController::class, 'index'])->name('review_photos.index')->defaults('title', 'Review Photos');
    Route::get('/Reports', [ReportsController::class, 'index'])->name('reports.index')->defaults('title', 'Reports');
});

// ================= PROJECT COORDINATOR (role: 3) =================
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('/coordinator', [CoordinatorController::class, 'index'])->name('coordinator.dashboard')->defaults('title', 'Dashboard');


Route::get('/project_management', [ProjectManagementController::class, 'index'])->name('project_management.index')->defaults('title', 'Project Management');
    Route::post('/project_management/store', [ProjectManagementController::class, 'store'])->name('project_management.store');
    Route::post('/project_management/update/{id}', [ProjectManagementController::class, 'update'])->name('project_management.update');
    Route::post('/project_management/assign', [AssignTechnicianController::class, 'store'])->name('project_management.assign');

    Route::post('/project_management/assign', [AssignTechnicianController::class, 'store'])->name('project_management.assign');
    Route::get('/attendance_approval', [AttendanceApprovalController::class, 'index'])->name('attendance_approval.index')->defaults('title', 'Attendance Approval');
    Route::get('/proof_of_work_approval', [WorkApprovalController::class, 'index'])->name('proof_of_work_approval.index')->defaults('title', 'Proof of Work Approval');
});

// ================= TECHNICIAN (role: 4) =================
Route::middleware(['auth', 'role:4'])->group(function () {
    Route::get('/technician', [TechnicianController::class, 'index'])->name('technician.dashboard')->defaults('title', 'Dashboard');
    Route::get('/assign_projects', [AssignTechnicianController::class, 'index'])->name('assign_projects.index')->defaults('title', 'Assign Projects');
    Route::get('/attendance', [AttendanceMarkController::class, 'index'])->name('attendance.index')->defaults('title', 'Attendance');
    Route::get('/proof_of_work', [ImageUploadController::class, 'index'])->name('proof_of_work.index')->defaults('title', 'Image Upload');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->defaults('title', 'Profile');
});
