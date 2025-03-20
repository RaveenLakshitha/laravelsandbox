<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceViewController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AttendanceMarkController;

Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    Route::get('/attendance/view', [AttendanceViewController::class, 'index']);
});

Route::get('/hr/login', [HRAuthController::class, 'showLoginForm'])->name('hr.login');
Route::post('/hr/login', [HRAuthController::class, 'login'])->name('hr.login.submit');
Route::post('/hr/logout', [HRAuthController::class, 'logout'])->name('hr.logout');

Route::middleware('auth')->group(function () {
    Route::get('/hr/dashboard', function () {return view('hr.dashboard');})->name('hr.dashboard');// Example HR Dashboard
    
});

Route::get('/attendance/login', [AttendanceAuthController::class, 'showLoginForm'])->name('attendance.login');
Route::post('/attendance/login', [AttendanceAuthController::class, 'login'])->name('attendance.login.submit');
Route::post('/attendance/logout', [AttendanceAuthController::class, 'logout'])->name('attendance.logout');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/main/dashboard', [MainiViewController::class, 'dashboard'])->name('main.dashboard');
    Route::get('/attendance/view', [AttendanceViewController::class, 'index']);
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/mark-attendance', [AttendanceMarkController::class, 'showAttendanceForm']);  
    Route::post('/update-office-location', [SettingsController::class, 'updateOfficeLocation'])->name('update.office.location');  
    Route::post('/main/login', [MainAuthController::class, 'login'])->name('main.login');
    Route::post('/main/login', [MainAuthController::class, 'login'])->name('main.login');
    Route::post('/main/logout', [MainAuthController::class, 'logout'])->name('main.logout');
});

Route::group(['middleware' => ['auth', 'role:hr']], function () {
    Route::get('/attendance/dashboard', [AttendanceController::class, 'dashboard'])->name('attendance.dashboard');
}
);