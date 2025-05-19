@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Completed Patient Visits</h2>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Diagnosis</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visits as $visit)
                        <tr>
                            <td>{{ $visit->patient->full_name }}</td>
                            <td>
                                @if($visit->appointment)
                                    Dr. {{ $visit->appointment->slot->doctorfull_name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($visit->checkin_time)->format('M j, g:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($visit->checkout_time)->format('M j, g:i A') }}</td>
                            <td>
                                @if($visit->medicalRecord)
                                    {{ Str::limit($visit->medicalRecord->diagnosis, 30) }}
                                @else
                                    No record
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('staff.medical-records.show', $visit->medicalRecord->id ?? '') }}" 
                                   class="btn btn-sm btn-info" 
                                   @if(!$visit->medicalRecord) disabled @endif>
                                    View Record
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No completed visits found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $visits->links() }}
        </div>
    </div>
</div>
@endsection