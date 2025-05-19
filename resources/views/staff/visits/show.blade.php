@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Patient Visit Details</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Patient Information</h5>
                    <p><strong>Name:</strong> {{ $visit->patient->name }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $visit->status === 'checked_out' ? 'success' : 'primary' }}">
                            {{ str_replace('_', ' ', $visit->status) }}
                        </span>
                    </p>
                    <p><strong>Check-in Time:</strong> {{ $visit->checkin_time->format('M j, Y g:i A') }}</p>
                    @if($visit->checkout_time)
                        <p><strong>Check-out Time:</strong> {{ $visit->checkout_time->format('M j, Y g:i A') }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h5>Appointment Details</h5>
                    @if($visit->appointment)
                        <p><strong>Doctor:</strong> Dr. {{ $visit->appointment->slot->doctor->name }}</p>
                        <p><strong>Date:</strong> {{ $visit->appointment->slot->date->format('M j, Y') }}</p>
                        <p><strong>Time:</strong> {{ date('g:i A', strtotime($visit->appointment->slot->start_time)) }}</p>
                        <p><strong>Reason:</strong> {{ $visit->appointment->reason ?? 'Not specified' }}</p>
                    @else
                        <p>Walk-in patient (no appointment)</p>
                    @endif
                </div>
            </div>
            
            @if(!$visit->medicalRecord && $visit->status !== 'checked_out')
                <a href="{{ route('staff.medical-records.create', $visit->id) }}" class="btn btn-primary mb-3">
                    Add Medical Record
                </a>
            @endif
            
            @if($visit->medicalRecord)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Medical Record</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Doctor:</strong> Dr. {{ $visit->medicalRecord->doctor->name }}</p>
                        <p><strong>Diagnosis:</strong> {{ $visit->medicalRecord->diagnosis }}</p>
                        <p><strong>Treatment:</strong> {{ $visit->medicalRecord->treatment }}</p>
                        @if($visit->medicalRecord->prescription)
                            <p><strong>Prescription:</strong> {{ $visit->medicalRecord->prescription }}</p>
                        @endif
                        @if($visit->medicalRecord->notes)
                            <p><strong>Notes:</strong> {{ $visit->medicalRecord->notes }}</p>
                        @endif
                    </div>
                </div>
            @endif
            
            @if($visit->status !== 'checked_out')
                <form action="{{ route('staff.visits.checkout', $visit->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Check Out Patient</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection