@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Book New Appointment - Select Doctor</h2>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                @forelse($doctors as $doctor)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="doctor-photo mb-3">
                                <img src="{{ $doctor->photo_url ?? asset('images/default-doctor.png') }}" 
                                     alt="{{ $doctor->name }}" class="rounded-circle" width="100">
                            </div>
                            <h5 class="card-title">{{ $doctor->full_name }}</h5>
                            <p class="text-muted">{{ $doctor->specialization }}</p>
                            <a href="{{ route('patient.appointments.create-step2', $doctor->id) }}" 
                               class="btn btn-primary">
                                View Available Slots
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No doctors available at the moment. Please check back later.
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection