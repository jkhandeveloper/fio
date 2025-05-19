@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create Medical Record for {{ $visit->patient->full_name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('staff.medical-records.store', $visit->id) }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="doctor_id" class="form-label">Attending Doctor</label>
                    <select name="doctor_id" id="doctor_id" class="form-select" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" 
                            {{ $visit->appointment && $visit->appointment->slot->doctor_id == $doctor->id ? 'selected' : '' }}>
                            Dr. {{ $doctor->full_name }} ({{ $doctor->specialization ?? 'General' }})
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="diagnosis" class="form-label">Diagnosis</label>
                    <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="treatment" class="form-label">Treatment</label>
                    <textarea name="treatment" id="treatment" class="form-control" rows="3" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="prescription" class="form-label">Prescription (Optional)</label>
                    <textarea name="prescription" id="prescription" class="form-control" rows="2"></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="notes" class="form-label">Additional Notes (Optional)</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Save Medical Record</button>
                <a href="{{ route('staff.visits.active') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection