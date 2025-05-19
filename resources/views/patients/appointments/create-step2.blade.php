@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Book Appointment with Dr. {{ $doctor->full_name }}</h2>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('patient.appointments.store') }}">
                @csrf
                
                <div class="mb-4">
                    <h5>Available Time Slots</h5>
                    @if($availableSlots->isEmpty())
                        <div class="alert alert-info">
                            No available slots for this doctor. Please check back later.
                        </div>
                    @else
                        <div class="row">
                            @foreach($availableSlots->groupBy('date') as $date => $slots)
                            <div class="col-md-6 mb-4">
                                <h6>{{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}</h6>
                                <div class="list-group">
                                    @forelse($slots as $slot)
                                    <label class="list-group-item">
                                        <input type="radio" name="slot_id" 
                                               value="{{ $slot->id }}" required>
                                        {{ date('g:i A', strtotime($slot->start_time)) }} - 
                                        {{ date('g:i A', strtotime($slot->end_time)) }}
                                    </label>
                                    @empty
                                    <div class="list-group-item">
                                        No slots available for this date.
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                @if(!$availableSlots->isEmpty())
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason for Appointment (Optional)</label>
                    <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('patient.appointments.create') }}" class="btn btn-secondary">
                        Back to Doctor Selection
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Confirm Appointment
                    </button>
                </div>
                @else
                <a href="{{ route('patient.appointments.create') }}" class="btn btn-secondary">
                    Back to Doctor Selection
                </a>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection