@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Active Patient Visits</h2>
    
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Check-in Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($visits->isEmpty())
                        <tr><td colspan="5"><p>No available slots. Create new slots for patients to book.</p></td></tr>
                    @else
                    @forelse($visits as $visit)
                    <tr>
                        <td>{{ $visit->patient->full_name }}</td>
                        <td>Dr. {{ $visit->appointment->slot->doctor->full_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($visit->checkin_time)->format('g:i A') }}</td>
                        <td>
                            <span class="badge bg-{{ $visit->status == 'checked_in' ? 'primary' : 'warning' }}">
                                {{ str_replace('_', ' ', $visit->status) }}
                            </span>
                        </td>
                        <td>
                            @if($visit->status == 'checked_in')
                                <a href="{{ route('staff.visits.send-to-doctor', $visit->id) }}" 
                                   class="btn btn-sm btn-success">
                                    Send to Doctor
                                </a>
                            @else
                                <a href="{{ route('staff.medical-records.create', $visit->id) }}" 
                                   class="btn btn-sm btn-info">
                                    Add Medical Record
                                </a>
                                <a href="{{ route('staff.visits.checkout', $visit->id) }}" 
                                   class="btn btn-sm btn-primary">
                                    Check Out
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No active visits found</td>
                    </tr>
                    @endforelse
                    @endif
                </tbody>
            </table>
            {{ $visits->links() }}
        </div>
    </div>
</div>
@endsection