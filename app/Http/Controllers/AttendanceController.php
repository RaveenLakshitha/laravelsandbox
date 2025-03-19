<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Helpers\LocationHelper;
class AttendanceController extends Controller
{
    public function store(Request $request)
{
    \Log::info('Attendance request received', $request->all()); // Log request

    $request->validate([
        'employee_id' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    // $officeLat = env('OFFICE_LATITUDE', 5.9998208);
    // $officeLon = env('OFFICE_LONGITUDE', 80.2619392);
    $officeLat = env('OFFICE_LATITUDE', 6.6361117);
    $officeLon = env('OFFICE_LONGITUDE', 80.7125395);
    $radius = env('RADIUS_METERS', 10);

    $distance = LocationHelper::getDistance(
        $request->latitude,
        $request->longitude,
        $officeLat,
        $officeLon
    );

    \Log::info('Comparing locations', [
        'office_lat' => $officeLat,
        'office_lon' => $officeLon,
        'request_lat' => $request->latitude,
        'request_lon' => $request->longitude,
    ]);

    \Log::info('Calculated Distance', ['distance' => $distance]);

    if ($distance > $radius) {
        \Log::info('Employee outside allowed area', ['distance' => $distance]);
        
        return response()->json([
            'error' => true,
            'message' => 'You are outside the allowed attendance area.'
        ], 403);
    }

    $attendance = Attendance::create([
        'employee_id' => $request->employee_id,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    \Log::info('Attendance recorded successfully', $attendance->toArray());

    return response()->json([
        'message' => 'Attendance recorded!',
        'data' => $attendance
    ], 201);
}

    public function index()
    {
        return response()->json(Attendance::latest()->get());
    }
}

