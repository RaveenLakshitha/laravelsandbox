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

}