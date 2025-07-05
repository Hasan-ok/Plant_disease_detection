<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Appointment Booked</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f8fa;
            padding: 20px;
            color: #333;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
        }

        h2 {
            color: #2f855a;
        }

        .info {
            margin-bottom: 10px;
        }

        .info strong {
            display: inline-block;
            width: 150px;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>📅 New Appointment Booked</h2>

        <p>You have a new appointment request. Here are the details:</p>

        <div class="info"><strong>Client Name:</strong> {{ $appointment->name }}</div>
        <div class="info"><strong>Email:</strong> {{ $appointment->email }}</div>
        <div class="info"><strong>Preferred Date:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}</div>
        <div class="info"><strong>Preferred Time:</strong> {{ \Carbon\Carbon::createFromFormat('H:i', $appointment->time)->format('h:i A') }}</div>
        <div class="info"><strong>Tree Type:</strong> {{ $appointment->tree_type }}</div>
        <div class="info"><strong>Observed Issue:</strong> {{ $appointment->issue }}</div>
        <div class="info"><strong>Suspected Disease:</strong> {{ $appointment->disease ?? 'N/A' }}</div>
        <div class="info"><strong>User Suggested Treatment:</strong> {{ $appointment->user_treatment ?? 'N/A' }}</div>

        @if($appointment->tree_image)
            <div class="info">
                <strong>Tree Image:</strong><br>
                <img src="{{ asset('storage/' . $appointment->tree_image) }}" alt="Tree Image" style="max-width: 100%; border: 1px solid #ddd; margin-top: 10px;">
            </div>
        @endif

        <div class="footer">
            This is an automated message from the Plant Disease Detection System.
        </div>
    </div>
</body>
</html>
