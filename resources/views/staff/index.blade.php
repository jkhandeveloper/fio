@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h1>Staff</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('staff.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Staff
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $s)
                        <tr>
                            <td>{{ $s->full_name }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->phone }}</td>
                            <td>
                                <a href="{{ route('staff.show', $s->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('staff.edit', $s->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('staff.destroy', $s->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No staff found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $staff->links() }}
            </div>
        </div>
    </div>
</div>
@endsection