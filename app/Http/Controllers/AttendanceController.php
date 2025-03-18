<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Helpers\LocationHelper;
class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $officeLat = env('OFFICE_LATITUDE', 6.9271); // Default if env not set
        $officeLon = env('OFFICE_LONGITUDE', 79.8612);
        $radius = env('RADIUS_METERS', 100);

        $distance = LocationHelper::getDistance(
            $request->latitude,
            $request->longitude,
            $officeLat,
            $officeLon
        );

        if ($distance > $radius) {
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

        return response()->json(['message' => 'Attendance recorded!', 'data' => $attendance], 201);
    }

    public function index()
    {
        return response()->json(Attendance::latest()->get());
    }
}

