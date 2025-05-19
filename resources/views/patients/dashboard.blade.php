@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Patient Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Total Appointments</h5>
                    <h2>{{ $stats['total_appointments'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5>Today's Appointments</h5>
                    <h2>{{ $stats['today_appointments'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h5>Upcoming Appointments</h5>
                    <h2>{{ $stats['upcoming_appointments'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Appointments -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Today's Appointments</h4>
        </div>
        <div class="card-body">
            @if($todayAppointments->isEmpty())
                <p>No appointments scheduled for today.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Time</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment->slot->doctor->full_name }}</td>
                                <td>
                                    {{ date('g:i A', strtotime($appointment->slot->start_time)) }} - 
                                    {{ date('g:i A', strtotime($appointment->slot->end_time)) }}
                                </td>
                                <td>{{ $appointment->reason ?? 'Not specified' }}</td>
                                <td>
                                    <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'primary' : 'secondary' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('patient.appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No appointments scheduled for today.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Upcoming Appointments</h4>
                    <a href="{{ route('patient.appointments.create') }}" class="btn btn-sm btn-primary">Book New Appointment</a>
                </div>
                <div class="card-body">
                    @if($upcomingAppointments->isEmpty())
                        <p>No upcoming appointments.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Doctor</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($upcomingAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->slot->date->format('D, M j') }}</td>
                                        <td>{{ $appointment->slot->doctor->full_name }}</td>
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
                                            <form action="{{ route('patient.appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No upcoming appointments.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Doctors -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Your Doctors</h4>
                </div>
                <div class="card-body">
                    @if($recentDoctors->isEmpty())
                        <p>You haven't booked with any doctors yet.</p>
                    @else
                        <div class="list-group">
                            @forelse($recentDoctors as $doctor)
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $doctor->full_name }}</h5>
                                        <small class="text-muted">{{ $doctor->specialization }}</small>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('patient.appointments.create-step2', $doctor->id) }}" 
                                       class="btn btn-sm btn-outline-primary">Book Again</a>
                                </div>
                            </div>
                            @empty
                            <div class="list-group-item">
                                <p class="mb-0">No recent doctors found.</p>
                            </div>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection