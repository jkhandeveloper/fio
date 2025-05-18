@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h1>Staff Details</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('staff.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="mb-4">{{ $staff->full_name }}</h3>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Email:</strong> {{ $staff->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phone:</strong> {{ $staff->phone }}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Position:</strong> {{ $staff->position }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Department:</strong> {{ $staff->department }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Salary:</strong> {{ $staff->salary }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Hire Date:</strong> {{ \Carbon\Carbon::parse($staff->hire_date)->format('d-m-Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" style="display: inline-block;">
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