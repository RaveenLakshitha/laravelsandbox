<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceViewController extends Controller
{
    public function index()
    {
        $attendances = Attendance::latest()->get();
        return view('attendance.index', compact('attendances'));
    }
}