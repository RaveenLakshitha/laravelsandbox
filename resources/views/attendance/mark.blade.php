@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mark Attendance</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form id="attendanceForm" method="POST" action="{{ url('/mark-attendance') }}">
        @csrf
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">

        <div class="mb-3">
            <label for="employee_id" class="form-label">Employee ID</label>
            <input type="text" class="form-control" id="employee_id" name="employee_id" required>
        </div>

        <button type="submit" class="btn btn-primary" id="markAttendanceBtn" disabled>Mark Attendance</button>
    </form>
</div>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    document.getElementById('markAttendanceBtn').disabled = false;
                },
                function(error) {
                    alert('Error getting location. Please enable location services.');
                }
            );
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    }

    document.addEventListener('DOMContentLoaded', getLocation);
</script>
@endsection
