<h2>Appointment Updated</h2>

<p>The appointment has been updated with the following details:</p>

<ul>
    <li><strong>User:</strong> {{ $appointment->name }}</li>
    <li><strong>Email:</strong> {{ $appointment->email }}</li>
    <li><strong>New Date:</strong> {{ $appointment->date }}</li>
    <li><strong>New Time:</strong> {{ $appointment->time }}</li>
    <li><strong>Tree Type:</strong> {{ $appointment->tree_type }}</li>
</ul>
