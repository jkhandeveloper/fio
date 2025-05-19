@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Staff Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Today's Appointments</h5>
                    <h2>{{ $counts['todays_appointments'] }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('staff.visits.index') }}">
                        View Appointments
                    </a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-warning text-dark mb-4">
                <div class="card-body">
                    <h5>Active Visits</h5>
                    <h2>{{ $counts['active_visits'] }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-dark stretched-link" href="{{ route('staff.visits.active') }}">
                        Manage Visits
                    </a>
                    <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5>Completed Today</h5>
                    <h2>{{ $counts['completed_visits'] }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('staff.visits.completed') }}">
                        View Completed
                    </a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Appointments -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Today's Appointments</h5>
                <a href="{{ route('staff.visits.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
        </div>
        <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
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
                            @forelse($todaysAppointments as $appointment)
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
                                       class="btn btn-sm btn-outline-primary">
                                        Check In
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
                </div>
        </div>
    </div>

    <!-- Active Visits -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Active Visits</h5>
                        <a href="{{ route('staff.visits.active') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($activeVisits->isEmpty())
                        <p class="mb-0">No active visits currently.</p>
                    @else
                        <div class="list-group">
                            @foreach($activeVisits as $visit)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $visit->patient->full_name }}</h6>
                                    <small>{{ \Carbon\Carbon::parse($visit->checkin_time)->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">
                                    @if($visit->appointment)
                                        Dr. {{ $visit->appointment->slot->doctor->full_name }}
                                    @else
                                        Walk-in Patient
                                    @endif
                                </p>
                                <div class="d-flex justify-content-end">
                                    
                                    @if($visit->status === 'checked_in')
                                        <form action="{{ route('staff.visits.send-to-doctor', $visit->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                To Doctor
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Completed -->
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recently Completed</h5>
                        <a href="{{ route('staff.visits.completed') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentCompleted->isEmpty())
                        <p class="mb-0">No completed visits today.</p>
                    @else
                        <div class="list-group">
                            @foreach($recentCompleted as $visit)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $visit->patient->full_name }}</h6>
                                    <small>{{ \Carbon\Carbon::parse($visit->checkout_time)->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">
                                    @if($visit->appointment)
                                        Dr. {{ $visit->appointment->slot->doctor->full_name }}
                                    @else
                                        Walk-in Patient
                                    @endif
                                </p>
                                <small>
                                    @if($visit->medicalRecord)
                                        {{ Str::limit($visit->medicalRecord->diagnosis, 50) }}
                                    @else
                                        No medical record
                                    @endif
                                </small>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection