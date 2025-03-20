<?php

use App\Http\Controllers\AttendanceAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authenticated user route (requires Sanctum auth)
// User authentication (Sanctum token-based)
Route::post('/attendance/login', [AttendanceAuthController::class, 'apiLogin']);
Route::post('/attendance/logout', [AttendanceAuthController::class, 'apiLogout'])->middleware('auth:sanctum');

// ------------------- SECURED ATTENDANCE ROUTES -------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // Attendance API (only accessible after login)
    Route::post('/attendance', [AttendanceController::class, 'store']);
    Route::get('/attendance', [AttendanceController::class, 'index']);
});
