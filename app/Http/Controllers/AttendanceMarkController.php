<?php

namespace App\Http\Controllers;

use App\Helpers\LocationHelper;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceMarkController extends Controller
{
    public function index()
    {
        $attendances = Attendance::latest()->get();
        return view('attendance.index', compact('attendances'));
    }

public function showAttendanceForm()
{
    return view('attendance.mark');
}

public function store(Request $request)
{
    $request->validate([
        'employee_id' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    $officeLat = env('OFFICE_LATITUDE', 6.909634);
    $officeLon = env('OFFICE_LONGITUDE', 79.9669855);
    $radius = env('RADIUS_METERS', 100);

    $distance = LocationHelper::getDistance(
        $request->latitude,
        $request->longitude,
        $officeLat,
        $officeLon
    );

    if ($distance > $radius) {
        return back()->with('error', 'You are outside the allowed attendance area.');
    }

    Attendance::create([
        'employee_id' => $request->employee_id,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    return back()->with('success', 'Attendance marked successfully.');
}
}