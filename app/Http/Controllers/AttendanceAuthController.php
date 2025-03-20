<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AttendanceAuthController extends Controller
{
    // ------------------- LOGIN -------------------
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_id' => 'required'
        ]);

        $user = User::where('email', $request->email)->where('role', 'attendance')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        // Check if the user is already logged in from another device
        if ($user->device_id && $user->device_id !== $request->device_id) {
            return response()->json(['message' => 'Another device is already logged in. Logout first.'], 403);
        }

        // Store new device ID (overwrite previous)
        $user->device_id = $request->device_id;
        $user->save();

        // Create a permanent token (does not expire unless manually revoked)
        $token = $user->createToken('attendance_token')->plainTextToken;

        return response()->json(['message' => 'Login successful', 'token' => $token]);
    }

    // ------------------- LOGOUT -------------------
    public function apiLogout(Request $request)
    {
        $user = $request->user();
        $user->device_id = null; // Clear device ID
        $user->tokens()->delete(); // Invalidate all tokens
        $user->save();

        return response()->json(['message' => 'Logout successful']);
    }
}
