@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Appointment Slots</h2>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('doctor.slots.store') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" 
                           min="{{ date('Y-m-d') }}"value="{{ old('date') }}" required>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" 
                               name="start_time" value="{{ old('start_time', '09:00') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" 
                               name="end_time" value="{{ old('end_time', '09:00') }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="duration" class="form-label">Slot Duration (minutes)</label>
                        <input type="number" class="form-control" id="duration" 
                               name="duration" min="5" max="60" value="30" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Create Slots</button>
            </form>
        </div>
    </div>
</div>
@endsection