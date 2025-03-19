<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AttendanceViewController;

Route::get('/attendance/view', [AttendanceViewController::class, 'index']);

use App\Http\Controllers\AttendanceMarkController;

Route::get('/mark-attendance', [AttendanceMarkController::class, 'showAttendanceForm']);