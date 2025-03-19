<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AttendanceViewController;

Route::get('/attendance/view', [AttendanceViewController::class, 'index']);

use App\Http\Controllers\AttendanceMarkController;

Route::get('/mark-attendance', [AttendanceMarkController::class, 'showAttendanceForm']);

use App\Http\Controllers\SettingsController;

Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('/update-office-location', [SettingsController::class, 'updateOfficeLocation'])->name('update.office.location');
