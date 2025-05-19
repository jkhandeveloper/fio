@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Today's Appointments</h2>
    
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->full_name }}</td>
                        <td>Dr. {{ $appointment->slot->doctor->full_name }}</td>
                        <td>{{ date('g:i A', strtotime($appointment->slot->start_time)) }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ ucfirst($appointment->visit_status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('staff.visits.verify', $appointment->id) }}" 
                               class="btn btn-sm btn-primary">
                                Verify & Check In
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No appointments scheduled for today.</td>  
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection