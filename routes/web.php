<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfficerReportController;
use App\Http\Livewire\UserManagement;
use App\Http\Livewire\DocumentManagement;
use App\Http\Livewire\ReportDashboard;
use App\Http\Livewire\LocationManagement;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('login'));
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'super_admin') {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'officer') {
            return redirect()->route('officer.dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors('Unauthorized access.');
        }
    })->name('dashboard');
});

Route::get('login',[AuthController::class,'login'])->name('login');

Route::get('register',[AuthController::class,'register'])->name('register');
Route::post('store',[AuthController::class,'store'])->name('store');
Route::post('login',[AuthController::class,'doLogin'])->name('auth_login');

Route::get('/verify/{code}', [AuthController::class,'verify'])->name('verify_link');

Route::get('logout', function (){
    Auth::logout();
    return redirect(route('login'));
})->name('logout');

// Password Reset Routes
Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

// Role-based dashboard routes
Route::middleware(['auth', RoleMiddleware::class . ':super_admin'])->group(function () {
    Route::get('superadmin/dashboard', [\App\Http\Controllers\SuperAdminController::class, 'dashboardOverview'])->name('superadmin.dashboard');
    Route::get('superadmin/admins', [\App\Http\Controllers\SuperAdminController::class, 'admins'])->name('superadmin.admins');
    Route::get('superadmin/officers', [\App\Http\Controllers\SuperAdminController::class, 'officers'])->name('superadmin.officers');
    Route::get('superadmin/documents', [\App\Http\Controllers\SuperAdminController::class, 'documents'])->name('superadmin.documents');
    Route::post('superadmin/admins', [\App\Http\Controllers\SuperAdmin\AdminController::class, 'store'])->name('superadmin.admins.store');
    Route::get('superadmin/admins/{id}/edit', [\App\Http\Controllers\SuperAdmin\AdminController::class, 'edit'])->name('superadmin.admins.edit');
    Route::put('superadmin/admins/{id}', [\App\Http\Controllers\SuperAdmin\AdminController::class, 'update'])->name('superadmin.admins.update');
    Route::delete('superadmin/admins/{id}', [\App\Http\Controllers\SuperAdmin\AdminController::class, 'destroy'])->name('superadmin.admins.destroy');
    Route::get('super-admin/dashboard', function () {
        return redirect()->route('superadmin.dashboard');
    });
    // TEMP: Make locations management route public for debugging
    Route::get('superadmin/locations', function () {
        return view('superadmin.locations');
    })->name('superadmin.locations');
});

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'overview'])->name('admin.dashboard');
    Route::get('admin/officers', [AdminController::class, 'officers'])->name('admin.officers');
    Route::get('admin/assignments', [AdminController::class, 'assignments'])->name('admin.assignments');
    Route::get('admin/documents', [AdminController::class, 'documents'])->name('admin.documents');
    Route::post('admin/assign-officer', [AdminController::class, 'assignOfficer'])->name('admin.assign_officer');
    Route::delete('admin/remove-assignment/{id}', [AdminController::class, 'removeAssignment'])->name('admin.remove_assignment');
    Route::post('admin/create-officer', [AdminController::class, 'createOfficer'])->name('admin.create_officer');
});

Route::middleware(['auth', RoleMiddleware::class . ':officer'])->group(function () {
    Route::get('officer/dashboard', [OfficerReportController::class, 'dashboard'])->name('officer.dashboard');
    Route::get('officer/report-form', [OfficerReportController::class, 'create'])->name('officer.report_form');
    Route::post('officer/submit-report', [OfficerReportController::class, 'store'])->name('officer.submit_report');
    Route::get('officer/documents', [OfficerReportController::class, 'documents'])->name('officer.documents');
});

Route::get('test',TestController::class)->name('');
