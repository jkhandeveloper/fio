@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h1>Patient Details</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="mb-4">{{ $patient->full_name }}</h3>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Email:</strong> {{ $patient->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d-m-Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Gender:</strong> {{ $patient->gender }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p><strong>Medoca History:</strong></p>
                        <p>{{ $patient->medical_history ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Allergies:</strong></p>
                        <p>{{ $patient->allergies ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Address:</strong></p>
                        <p>{{ $patient->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection