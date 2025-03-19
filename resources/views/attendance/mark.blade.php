@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Employee Attendance</h2>

    <form id="attendanceForm">
        <div class="mb-3">
            <label for="employee_id" class="form-label">Employee ID</label>
            <input type="text" class="form-control" id="employee_id" name="employee_id" required>
        </div>
        
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">

        <button type="button" class="btn btn-primary" onclick="markAttendance()">Mark Attendance</button>
    </form>

    <div id="statusMessage" class="mt-3"></div>
</div>

<script>
    function getLocation() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                },
                function(error) {
                    console.error("Error getting location:", error);
                    alert("Please allow location access in your browser.");
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        } else {
            alert("Geolocation is not supported by your browser.");
        }
    }

    async function markAttendance() {
        getLocation(); // Get location before submission
        setTimeout(async () => { // Wait for location update
            let employeeId = document.getElementById('employee_id').value;
            let latitude = document.getElementById('latitude').value;
            let longitude = document.getElementById('longitude').value;

            if (!employeeId) {
                document.getElementById('statusMessage').innerHTML = "<p class='text-danger'>❗ Please enter Employee ID</p>";
                return;
            }

            if (!latitude || !longitude) {
                document.getElementById('statusMessage').innerHTML = "<p class='text-danger'>❗ Location not detected. Try again.</p>";
                return;
            }

            let postData = {
                employee_id: employeeId,
                latitude: latitude,
                longitude: longitude
            };

            try {
                let response = await fetch("{{ url('/api/attendance') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(postData),
                });

                let responseData = await response.json();

                if (response.ok) {
                    document.getElementById('statusMessage').innerHTML = `<p class='text-success'>✅ ${responseData.message}</p>`;
                } else {
                    document.getElementById('statusMessage').innerHTML = `<p class='text-danger'>❌ ${responseData.message}</p>`;
                }
            } catch (error) {
                console.error("Error sending attendance:", error);
                document.getElementById('statusMessage').innerHTML = "<p class='text-danger'>❌ Error submitting attendance. Try again.</p>";
            }
        }, 2000);
    }

    document.addEventListener("DOMContentLoaded", getLocation);
</script>
@endsection
