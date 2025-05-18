@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h1>Doctor Details</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="mb-4">{{ $doctor->full_name }}</h3>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>License Number:</strong> {{ $doctor->license_number }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Email:</strong> {{ $doctor->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p><strong>Address:</strong></p>
                        <p>{{ $doctor->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display: inline-block;">
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