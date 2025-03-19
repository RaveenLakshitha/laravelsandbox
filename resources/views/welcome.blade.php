<!DOCTYPE html>
<html>
<head>
    <title>Welcome Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Welcome to Attendance System</h1>

    <a href="{{ url('/attendance/view') }}" class="btn">View Attendance</a>
    <a href="{{ url('/mark-attendance') }}" class="btn">Mark Attendance</a>
    <a href="{{ route('settings') }}" class="btn">Settings</a>
</body>
</html>
