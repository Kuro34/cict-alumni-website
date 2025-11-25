@extends('layouts.alumni')

@section('content')
<div class="job-show-wrapper" style="max-width: 800px; margin: 2rem auto; padding: 0 1rem; font-family: Arial, sans-serif;">

    {{-- Back to Jobs Button --}}
    <button class="btn btn-outline-primary btn-job-action" style="margin-bottom: 1rem;" onclick="window.location.href='{{ route('jobs.index') }}'">
        <i class="bi bi-arrow-left-circle me-1"></i> Back to Jobs
    </button>

    {{-- Job Title & Company --}}
    <h1 style="font-size: 2rem; margin-bottom: 0.3rem;">{{ $job->title }}</h1>
    <p style="font-size: 1.1rem; color: #555; margin-bottom: 1rem;">{{ $job->company ?? '-' }}</p>

    {{-- Job Meta --}}
    <p style="color: #777; font-size: 0.95rem; margin-bottom: 1.5rem;">
        {{ $job->location ?? '-' }} &nbsp;|&nbsp; Posted by: {{ $job->admin->name ?? '-' }} &nbsp;|&nbsp; {{ $job->created_at->format('M d, Y') }}
    </p>
    
    {{-- Actions --}}
    <div style="margin-bottom: 2rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
        @if($alreadyApplied)
            <form action="{{ route('jobs.cancel', $job->jobID) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-job-action">
                    <i class="bi bi-x-circle me-1"></i> Cancel Application
                </button>
            </form>
            <span style="color: green; font-weight: 600; margin-left: 1rem; align-self: center;">You have applied</span>
        @else
            <button class="btn btn-primary btn-job-action" onclick="document.getElementById('applyForm').scrollIntoView({ behavior: 'smooth' })">
                <i class="bi bi-send-fill me-1"></i> Apply Now
            </button>
        @endif
        <button class="btn btn-outline-secondary btn-job-action" onclick="alert('Job reported. Admin will review.')">
            <i class="bi bi-flag-fill me-1"></i> Report Job
        </button>
    </div>

    {{-- Job Description --}}
    <h3 style="margin-bottom: 0.5rem;">Job Description</h3>
    <p style="margin-bottom: 1.5rem;">{!! nl2br(e($job->description ?? 'No description provided.')) !!}</p>

    {{-- Apply Form --}}
    @if(!$alreadyApplied)
    <div id="applyForm" style="margin-bottom: 2rem;">
        <h3>Apply to this Job</h3>
        <form action="{{ route('jobs.apply', $job->jobID) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label for="cover_letter">Cover Letter (optional)</label><br>
                <textarea name="cover_letter" id="cover_letter" rows="5" style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">{{ old('cover_letter') }}</textarea>
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="resume">Upload Resume (optional)</label><br>
                <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" style="margin-top: 0.3rem;">
            </div>
            <button type="submit" class="btn btn-primary btn-job-action">
                Submit Application
            </button>
        </form>
    </div>
    @endif

    {{-- Job Details --}}
    <div>
        <h3>Job Details</h3>
        <ul style="list-style: none; padding-left: 0;">
            <li><strong>Company:</strong> {{ $job->company ?? '-' }}</li>
            <li><strong>Location:</strong> {{ $job->location ?? '-' }}</li>
            <li><strong>Posted by:</strong> {{ $job->admin->name ?? '-' }}</li>
            <li><strong>Date Posted:</strong> {{ $job->created_at->format('M d, Y') }}</li>
            @if($job->salary)
            <li><strong>Salary:</strong> {{ $job->salary }}</li>
            @endif
            @if($job->job_type)
            <li><strong>Job Type:</strong> {{ $job->job_type }}</li>
            @endif
            <li><strong>Status:</strong> 
                @if($alreadyApplied)
                    Applied
                @else
                    Not Applied
                @endif
            </li>
        </ul>
    </div>

</div>

@push('styles')
<style>
    /* Buttons styled like bookmark buttons */
    .btn-job-action {
        border-radius: 25px;
        padding: 0.5rem 1.2rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-job-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .btn-job-action i {
        font-size: 1rem;
    }

    /* Buttons spacing on small screens */
    @media (max-width: 576px) {
        .btn-job-action { width: 100%; justify-content: center; }
    }
</style>
@endpush
@endsection
