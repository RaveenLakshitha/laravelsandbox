<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Location Settings</title>
</head>
<body>
    <h2>Update Office Location</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('update.office.location') }}">
        @csrf
        <label for="latitude">Office Latitude:</label>
        <input type="text" id="latitude" name="latitude" required value="{{ $officeLat }}">
        
        <label for="longitude">Office Longitude:</label>
        <input type="text" id="longitude" name="longitude" required value="{{ $officeLon }}">
        
        <button type="submit">Save Location</button>
        <button type="button" onclick="history.back()">Back</button>
    </form>
</body>
</html>
