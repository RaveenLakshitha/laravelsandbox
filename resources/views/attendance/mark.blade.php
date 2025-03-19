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
    async function getLocation() {
        document.getElementById('statusMessage').innerHTML = "<p class='text-warning'>⏳ Getting location...</p>";

        if (!navigator.geolocation) {
            document.getElementById('statusMessage').innerHTML = "<p class='text-danger'>❗ Geolocation is not supported by your browser.</p>";
            return null;
        }

        return new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;
                    document.getElementById('statusMessage').innerHTML = `<p class='text-success'>✅ Location detected: ${latitude}, ${longitude}</p>`;

                    resolve({ latitude, longitude });
                },
                (error) => {
                    document.getElementById('statusMessage').innerHTML = `<p class='text-danger'>❗ Error: ${error.message}</p>`;
                    reject(error);
                },
                { enableHighAccuracy: true, timeout: 100000 }
            );
        });
    }

    async function markAttendance() {
        try {
            let employeeId = document.getElementById('employee_id').value;
            if (!employeeId) {
                document.getElementById('statusMessage').innerHTML = "<p class='text-danger'>❗ Please enter Employee ID</p>";
                return;
            }

            // Get the location and wait for it
            const location = await getLocation();
            if (!location) return;

            let postData = {
                employee_id: employeeId,
                latitude: location.latitude,
                longitude: location.longitude
            };

            console.log("📤 Sending data:", postData);

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
            console.error("❌ Error submitting attendance:", error);
            document.getElementById('statusMessage').innerHTML = "<p class='text-danger'>❌ Error submitting attendance. Try again.</p>";
        }
    }

    // Auto-fetch location when the page loads
    document.addEventListener("DOMContentLoaded", getLocation);
</script>

@endsection
