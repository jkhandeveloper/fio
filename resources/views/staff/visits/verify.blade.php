@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Verify Patient: {{ $appointment->patient->full_name }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Appointment Details</h5>
                    <p><strong>Doctor:</strong> Dr. {{ $appointment->slot->doctor->full_name }}</p>
                    <p><strong>Time:</strong> {{ date('g:i A', strtotime($appointment->slot->start_time)) }}</p>
                    <p><strong>Reason:</strong> {{ $appointment->reason ?? 'Not specified' }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Patient Information</h5>
                    <p><strong>Name:</strong> {{ $appointment->patient->full_name }}</p>
                    <p><strong>Email:</strong> {{ $appointment->patient->email }}</p>
                    <p><strong>Phone:</strong> {{ $appointment->patient->phone ?? 'N/A' }}</p>
                </div>
            </div>
            
            <form action="{{ route('staff.visits.checkin', $appointment->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Confirm Check In</button>
                <a href="{{ route('staff.visits.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection