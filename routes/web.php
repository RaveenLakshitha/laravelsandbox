<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AttendanceController;

Route::post('/attendance', [AttendanceController::class, 'store']);
Route::get('/attendance', [AttendanceController::class, 'index']);

use App\Http\Controllers\AttendanceViewController;

Route::get('/attendance/view', [AttendanceViewController::class, 'index']);