<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Helpers\LocationHelper;
use App\Models\Setting;

class AttendanceController extends Controller
{
    public function store(Request $request)
{
    $officeLat = Setting::getValue('office_latitude');
    $officeLon = Setting::getValue('office_longitude');

    \Log::info('Attendance request received', $request->all()); // Log request

    $request->validate([
        'employee_id' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    // $officeLat = env('OFFICE_LATITUDE', 5.9998208);
    // $officeLon = env('OFFICE_LONGITUDE', 80.2619392);
    // $officeLat = env('OFFICE_LATITUDE', 6.6357887);
    // $officeLon = env('OFFICE_LONGITUDE', 80.7119126);
    $radius = env('RADIUS_METERS', 100);

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
            'message' => 'You are outside the allowed attendance area.',
            'distance' => $distance,
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
        'data' => $attendance,
        'distance' => $distance,
    ], 201);
}
}

