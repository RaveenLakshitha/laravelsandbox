@extends('layouts.app')

@section('title', 'Attendance Records')

@section('content')
<div class="container">
    <h2>Attendance Records</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Checked In At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->employee_id }}</td>
                <td>{{ $attendance->latitude }}</td>
                <td>{{ $attendance->longitude }}</td>
                <td>{{ $attendance->checked_in_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
