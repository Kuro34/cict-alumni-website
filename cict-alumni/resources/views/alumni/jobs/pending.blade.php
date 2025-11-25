@extends('layouts.alumni')

@section('content')
<div class="directory-container">
    <h1>My Applications</h1>

    <button onclick="window.location='{{ route('jobs.index') }}'" 
        class="btn btn-primary rounded-pill mb-4" style="margin-bottom: 2rem; position: relative; z-index: 10;">
        <i class="bi bi-arrow-left me-1"></i> Back to All Jobs
    </button>

    <div class="job-list">
        @forelse($pendingApplications as $application)
            @php $job = $application->job; @endphp
            <div class="job-card">
                <div class="job-card-body">
                    <div class="job-card-info">
                        <h3>{{ $job->title }}</h3>
                        <p><i class="bi bi-building"></i> {{ $job->company ?? '-' }}</p>
                        <p><i class="bi bi-geo-alt"></i> {{ $job->location ?? '-' }}</p>
                        <p><i class="bi bi-person"></i> {{ $job->admin->name ?? '-' }}</p>
                    </div>
                    <div class="job-card-actions">
                        <a href="{{ route('jobs.show', $job->jobID) }}" 
                            class="btn btn-outline-primary view-btn">
                            <i class="fas fa-eye me-1"></i> View
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p>You haven't applied to any jobs yet.</p>
        @endforelse
    </div>
</div>

<style>
.directory-container { padding: 2rem 1rem; }
.btn-primary, .btn-outline-primary { border-radius: 50px; font-weight: 500; padding: 8px 20px; cursor: pointer; }
.job-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
.job-card { background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.2s, box-shadow 0.2s; }
.job-card:hover { transform: translateY(-4px); box-shadow: 0 6px 16px rgba(0,0,0,0.12); }
.job-card-body { padding: 1rem; display: flex; flex-direction: column; justify-content: space-between; height: 100%; }
.job-card-info h3 { margin-bottom: 0.5rem; font-size: 1.25rem; color: #333; }
.job-card-info p { margin: 0.2rem 0; color: #555; font-size: 0.95rem; }
.job-card-info i { margin-right: 0.3rem; color: #777; }
.job-card-actions { display: flex; justify-content: flex-end; align-items: center; margin-top: 1rem; }
.view-btn { border-radius: 25px; padding: 6px 16px; font-weight: 500; display: flex; align-items: center; gap: 4px; }
</style>
@endsection
