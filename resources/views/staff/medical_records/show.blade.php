@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Medical Record Details</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Patient Information</h5>
                    @if($record->visit && $record->visit->patient)
                        <p><strong>Name:</strong> {{ $record->visit->patient->full_name }}</p>
                        <p><strong>Visit Date:</strong> {{ $record->visit->checkin_time->format('M j, Y') }}</p>
                        <p><strong>Check-in:</strong> {{ $record->visit->checkin_time->format('g:i A') }}</p>
                        @if($record->visit->checkout_time)
                            <p><strong>Check-out:</strong> {{ $record->visit->checkout_time->format('g:i A') }}</p>
                        @endif
                    @else
                        <p class="text-danger">Patient visit information not available</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h5>Medical Information</h5>
                    @if($record->doctor)
                        <p><strong>Doctor:</strong> Dr. {{ $record->doctor->full_name }}</p>
                    @endif
                    <p><strong>Record Date:</strong> {{ $record->created_at->format('M j, Y g:i A') }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5>Diagnosis</h5>
                </div>
                <div class="card-body">
                    {{ $record->diagnosis }}
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5>Treatment</h5>
                </div>
                <div class="card-body">
                    {{ $record->treatment }}
                </div>
            </div>

            @if($record->prescription)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5>Prescription</h5>
                </div>
                <div class="card-body">
                    {{ $record->prescription }}
                </div>
            </div>
            @endif

            @if($record->notes)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5>Additional Notes</h5>
                </div>
                <div class="card-body">
                    {{ $record->notes }}
                </div>
            </div>
            @endif

            <a href="{{ route('staff.medical-records.index') }}" class="btn btn-secondary">
                Back to Records
            </a>
        </div>
    </div>
</div>
@endsection