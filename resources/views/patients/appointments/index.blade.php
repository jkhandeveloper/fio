@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>My Appointments</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary">Book New Appointment</a>
        </div>
     </div>
    
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->slot->doctor->full_name }}</td>
                        <td>{{ $appointment->slot->date->format('D, M j, Y') }}</td>
                        <td>
                            {{ date('g:i A', strtotime($appointment->slot->start_time)) }} - 
                            {{ date('g:i A', strtotime($appointment->slot->end_time)) }}
                        </td>
                        <td>
                            <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'primary' : 'secondary' }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td>
                            @if($appointment->status === 'scheduled')
                            <form action="{{ route('patient.appointments.destroy', $appointment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $appointments->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection