
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Doctor Dashboard</h1>
    
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
                    <h5>Available Slots</h5>
                    <h2>{{ $stats['available_slots'] }}</h2>
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
                                <th>Patient</th>
                                <th>Time</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment->patient->full_name }}</td>
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
                            </tr>
                            @empty  
                            <tr>
                                <td colspan="4" class="text-center">No appointments found</td>
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
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Upcoming Appointments</h4>
                </div>
                <div class="card-body">
                    @if($upcomingAppointments->isEmpty())
                        <p>No upcoming appointments.</p>
                    @else
                        <div class="list-group">
                            @forelse($upcomingAppointments as $appointment)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $appointment->patient->full_name }}</h5>
                                    <small>{{ $appointment->slot->date->format('M j') }}</small>
                                </div>
                                <p class="mb-1">
                                    {{ date('g:i A', strtotime($appointment->slot->start_time)) }} - 
                                    {{ date('g:i A', strtotime($appointment->slot->end_time)) }}
                                </p>
                                <small>{{ $appointment->reason ?? 'No reason provided' }}</small>
                            </div>

                            @empty
                            <div class="list-group-item">
                                <p class="mb-0">No upcoming appointments found.</p>
                            </div>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Available Slots -->
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Recent Available Slots</h4>
                    <a href="{{ route('doctor.slots.create') }}" class="btn btn-sm btn-primary">Add New Slots</a>
                </div>
                <div class="card-body">
                    @if($recentSlots->isEmpty())
                        <p>No available slots. Create new slots for patients to book.</p>
                    @else
                        <div class="list-group">
                            @forelse($recentSlots as $slot)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $slot->date->format('l, F j') }}</h5>
                                    <span class="badge bg-{{ $slot->isAvailable() ? 'success' : 'info' }}">{{ $slot->isAvailable() ? 'Available' : 'Booked' }}</span>
                                </div>
                                <p class="mb-1">
                                    {{ date('g:i A', strtotime($slot->start_time)) }} - 
                                    {{ date('g:i A', strtotime($slot->end_time)) }}
                                </p>
                                <div class="d-flex justify-content-end">
                                    <form action="{{ route('doctor.slots.destroy', $slot->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="list-group-item">
                                <p class="mb-0">No recent slots found.</p>  
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