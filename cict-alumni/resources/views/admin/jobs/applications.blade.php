@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Applications for: {{ $job->title }}</h1>

    <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary rounded-pill mb-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Jobs
    </a>

    @if($applications->isEmpty())
        <p>No applicants yet.</p>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Applicant Name</th>
                <th>Email</th>
                <th>Cover Letter</th>
                <th>Resume</th>
                <th>Applied At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $app)
            <tr>
                <td>{{ $app->alumni->first_name ?? '-' }} {{ $app->alumni->last_name ?? '' }}</td>
                <td>{{ $app->alumni->email ?? '-' }}</td>
                <td>{{ $app->cover_letter ?? '-' }}</td>
                <td>
                    @if($app->resume_path)
                        <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            Download
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $app->created_at->format('M d, Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
