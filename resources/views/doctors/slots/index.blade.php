@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row">
        <div class="col-md-6">
        <h2>My Appointment Slots</h2>
        </div>
        <div class="col-md-6 text-end">
        <a href="{{ route('doctor.slots.create') }}" class="btn btn-primary mb-3">Create New Slots</a>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slots as $slot)
                    <tr>
                        <td>{{ $slot->date->format('D, M j, Y') }}</td>
                        <td>{{ date('g:i A', strtotime($slot->start_time)) }}</td>
                        <td>{{ date('g:i A', strtotime($slot->end_time)) }}</td>
                        <td>
                            <span class="badge bg-{{ $slot->isAvailable() ? 'success' : 'danger' }}">
                                {{ $slot->isAvailable() ? 'Available' : 'Booked' }}
                            </span>
                        </td>
                        <td>
                            @if($slot->isAvailable())
                            <form action="{{ route('doctor.slots.destroy', $slot->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No available slots. Create new slots for patients to book.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $slots->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection