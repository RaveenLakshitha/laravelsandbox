<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background: #f4f4f4; }
        .container { width: 90%; max-width: 400px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; margin-bottom: 20px; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (navigator.userAgent) {
                document.getElementById("device_id").value = navigator.userAgent;
            }
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Attendance Login</h2>
        @if(session('error'))
            <p style="color: red; text-align: center;">{{ session('error') }}</p>
        @endif
        <form action="#" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="hidden" name="device_id" id="device_id">
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
