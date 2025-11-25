@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">All Job Postings</h1>

    <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary rounded-pill mb-3">
        <i class="bi bi-plus-circle me-1"></i> Add New Job
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Company</th>
                <th>Location</th>
                <th>Category</th>
                <th>Posted By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobs as $job)
            <tr>
                <td>{{ $job->title }}</td>
                <td>{{ $job->company ?? '-' }}</td>
                <td>{{ $job->location ?? '-' }}</td>
                <td>{{ $job->category ?? '-' }}</td>
                <td>{{ $job->admin->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.jobs.edit', $job->jobID) }}" class="btn btn-sm btn-warning me-1">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="{{ route('admin.jobs.applications', $job->jobID) }}" class="btn btn-sm btn-info me-1">
                        <i class="bi bi-people-fill"></i> Applications
                    </a>
                    <form action="{{ route('admin.jobs.destroy', $job->jobID) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to delete this job?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            <i class="bi bi-trash-fill"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No job postings found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $jobs->links() }}
</div>
@endsection
