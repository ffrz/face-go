<?php

use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\Auth;
use App\Http\Middleware\EmployeeAuth;
use App\Http\Middleware\NonAuthenticated;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Employee\AuthController as EmployeeAuthController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\ProfileController as EmployeeProfileController;
use App\Http\Controllers\Employee\AttendanceController as EmployeeAttendanceController;

Route::get('/', function () {
    return view('homepage');
})->name('home');

Route::get('/test', function () {
    return inertia('Test');
})->name('test');

Route::middleware(NonAuthenticated::class)->group(function () {
    Route::prefix('/admin/auth')->group(function () {
        Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('admin.auth.login');
        Route::match(['get', 'post'], 'register', [AuthController::class, 'register'])->name('admin.auth.register');
        Route::match(['get', 'post'], 'forgot-password', [AuthController::class, 'forgotPassword'])->name('admin.auth.forgot-password');
    });
});

Route::middleware([Auth::class])->group(function () {
    Route::prefix('api')->group(function () {
        // Route::get('active-employees', [ApiController::class, 'activeEmployees'])->name('api.active-employees');
    });

    Route::match(['get', 'post'], 'admin/auth/logout', [AuthController::class, 'logout'])->name('admin.auth.logout');

    Route::prefix('admin')->group(function () {
        Route::redirect('', 'admin/dashboard', 301);

        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('test', [DashboardController::class, 'test'])->name('admin.test');
        Route::get('about', function () {
            return inertia('admin/About');
        })->name('admin.about');

        Route::prefix('employees')->group(function () {
            Route::get('', [EmployeeController::class, 'index'])->name('admin.employee.index');
            Route::get('data', [EmployeeController::class, 'data'])->name('admin.employee.data');
            Route::get('detail/{id}', [EmployeeController::class, 'detail'])->name('admin.employee.detail');
            Route::get('add', [EmployeeController::class, 'editor'])->name('admin.employee.add');
            Route::get('edit/{id}', [EmployeeController::class, 'editor'])->name('admin.employee.edit');
            Route::get('duplicate/{id}', [EmployeeController::class, 'duplicate'])->name('admin.employee.duplicate');
            Route::post('save', [EmployeeController::class, 'save'])->name('admin.employee.save');
            Route::post('delete/{id}', [EmployeeController::class, 'delete'])->name('admin.employee.delete');
            Route::get('export', [EmployeeController::class, 'export'])->name('admin.employee.export');
        });

        Route::prefix('reports')->group(function () {
            Route::get('', [ReportController::class, 'index'])->name('admin.report.index');

            Route::get('interaction', [ReportController::class, 'interaction'])->name('admin.report.interaction');
            Route::get('sales-activity', [ReportController::class, 'salesActivity'])->name('admin.report.sales-activity');
            Route::get('sales-activity-detail', [ReportController::class, 'salesActivityDetail'])->name('admin.report.sales-activity-detail');

            Route::get('closing-detail', [ReportController::class, 'closingDetail'])->name('admin.report.closing-detail');
            Route::get('closing-by-sales', [ReportController::class, 'closingBySales'])->name('admin.report.closing-by-sales');
            Route::get('closing-by-services', [ReportController::class, 'closingByServices'])->name('admin.report.closing-by-services');

            Route::get('employee-services-active', [ReportController::class, 'employeeServicesActive'])->name('admin.report.employee-services-active');
            Route::get('employee-services-new', [ReportController::class, 'employeeServicesNew'])->name('admin.report.employee-services-new');
            Route::get('employee-services-ended', [ReportController::class, 'employeeServicesEnded'])->name('admin.report.employee-services-ended');

            Route::get('client-new', [ReportController::class, 'clientNew'])->name('admin.report.client-new');
            Route::get('client-active-inactive', [ReportController::class, 'clientActiveInactive'])->name('admin.report.client-active-inactive');
            Route::get('client-history', [ReportController::class, 'clientHistory'])->name('admin.report.client-history');

            Route::get('sales-performance', [ReportController::class, 'salesPerformance'])->name('admin.report.sales-performance');
        });

        Route::prefix('settings')->group(function () {
            Route::get('profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
            Route::post('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
            Route::post('profile/update-password', [ProfileController::class, 'updatePassword'])->name('admin.profile.update-password');

            Route::get('company-profile/edit', [CompanyProfileController::class, 'edit'])->name('admin.company-profile.edit');
            Route::post('company-profile/update', [CompanyProfileController::class, 'update'])->name('admin.company-profile.update');

            Route::prefix('users')->group(function () {
                Route::get('', [UserController::class, 'index'])->name('admin.user.index');
                Route::get('data', [UserController::class, 'data'])->name('admin.user.data');
                Route::get('add', [UserController::class, 'editor'])->name('admin.user.add');
                Route::get('edit/{id}', [UserController::class, 'editor'])->name('admin.user.edit');
                Route::get('duplicate/{id}', [UserController::class, 'duplicate'])->name('admin.user.duplicate');
                Route::post('save', [UserController::class, 'save'])->name('admin.user.save');
                Route::post('delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
                Route::get('detail/{id}', [UserController::class, 'detail'])->name('admin.user.detail');
                Route::get('export', [UserController::class, 'export'])->name('admin.user.export');
            });
        });
    });
});

Route::middleware(NonAuthenticated::class)->group(function () {
    Route::prefix('/employee/auth')->group(function () {
        Route::match(['get', 'post'], 'login', [EmployeeAuthController::class, 'login'])->name('employee.auth.login');
        Route::match(['get', 'post'], 'register', [EmployeeAuthController::class, 'register'])->name('employee.auth.register');
        Route::match(['get', 'post'], 'forgot-password', [EmployeeAuthController::class, 'forgotPassword'])->name('employee.auth.forgot-password');
    });
});

Route::middleware([EmployeeAuth::class])->prefix('employee')->group(function () {
    Route::match(['get', 'post'], 'auth/logout', [EmployeeAuthController::class, 'logout'])->name('employee.auth.logout');
    Route::redirect('', 'dashboard', 301);

    Route::get('dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
    Route::get('test', [EmployeeDashboardController::class, 'test'])->name('employee.test');
    Route::get('about', function () {
        return inertia('employee/About');
    })->name('employee.about');

    Route::prefix('attendance')->group(function() {
        Route::get('', [EmployeeAttendanceController::class, 'index'])->name('employee.attendance.index');
        Route::match(['get', 'post'], 'check-in', [EmployeeAttendanceController::class, 'checkIn'])->name('employee.attendance.check-in');
        Route::match(['get', 'post'], 'check-out', [EmployeeAttendanceController::class, 'checkOut'])->name('employee.attendance.check-out');
        Route::get('history', [EmployeeAttendanceController::class, 'history'])->name('employee.attendance.history');
        Route::get('historyData', [EmployeeAttendanceController::class, 'historyData'])->name('employee.attendance.history-data');
        Route::get('test', function() {
            return inertia('employee/attendance/Test');
        });
    });

    Route::get('profile/edit', [EmployeeProfileController::class, 'edit'])->name('employee.profile.edit');
    Route::post('profile/update', [EmployeeProfileController::class, 'update'])->name('employee.profile.update');
    Route::post('profile/update-password', [EmployeeProfileController::class, 'updatePassword'])->name('employee.profile.update-password');
});
