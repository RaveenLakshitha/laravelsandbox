<form method="POST" action="{{ route('update.office.location') }}">
    @csrf
    <label for="latitude">Office Latitude:</label>
    <input type="text" id="latitude" name="latitude" required value="{{ config('settings.office_lat') }}">
    
    <label for="longitude">Office Longitude:</label>
    <input type="text" id="longitude" name="longitude" required value="{{ config('settings.office_lon') }}">
    
    <button type="submit">Save Location</button>
</form>
