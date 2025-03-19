<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings', [
            'officeLat' => Setting::getValue('office_latitude'),
            'officeLon' => Setting::getValue('office_longitude'),
        ]);
    }

    public function updateOfficeLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Setting::setValue('office_latitude', $request->latitude);
        Setting::setValue('office_longitude', $request->longitude);

        return back()->with('success', 'Office location updated successfully.');
    }
}
