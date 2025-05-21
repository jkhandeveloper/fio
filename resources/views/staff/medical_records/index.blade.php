@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Medical Records</h2>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Diagnosis</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                        <tr>
                            <td>
                                @if($record->patientVisit && $record->patientVisit->patient)
                                    {{ $record->patientVisit->patient->full_name }}
                                @else
                                    <span class="text-muted">Patient not available</span>
                                @endif
                            </td>
                            <td>
                                @if($record->doctor)
                                    Dr. {{ $record->doctor->full_name }}
                                @else
                                    <span class="text-muted">Doctor not assigned</span>
                                @endif
                            </td>
                            <td>{{ $record->created_at->format('M j, Y') }}</td>
                            <td>
                                @if($record->diagnosis)
                                    {{ Str::limit($record->diagnosis, 50) }}
                                @else
                                    <span class="text-muted">No diagnosis recorded</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('staff.medical-records.show', $record->id) }}" 
                                class="btn btn-sm btn-info">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No medical records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $records->links() }}
        </div>
    </div>
</div>
@endsection