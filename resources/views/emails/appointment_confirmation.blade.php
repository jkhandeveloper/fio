<!-- resources/views/emails/appointment_confirmation.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
</head>
<body>
    <h1>Appointment Confirmation</h1>
    
    <p>Hello {{ $appointment->patient->full_name }},</p>
    
    <p>Your appointment has been successfully booked with Dr. {{ $appointment->slot->doctor->full_name }}.</p>
    
    <h3>Appointment Details:</h3>
    <ul>
        <li><strong>Date:</strong> {{ $appointment->slot->date->format('l, F j, Y') }}</li>
        <li><strong>Time:</strong> {{ date('g:i A', strtotime($appointment->slot->start_time)) }} to {{ date('g:i A', strtotime($appointment->slot->end_time)) }}</li>
        <li><strong>Reason:</strong> {{ $appointment->reason ?? 'Not specified' }}</li>
    </ul>
    
    <p>Thank you for using our service!</p>
    
    <p>
        <a href="{{ route('patient.appointments.index') }}">View Your Appointments</a>
    </p>
    
    <footer>
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </footer>
</body>
</html>