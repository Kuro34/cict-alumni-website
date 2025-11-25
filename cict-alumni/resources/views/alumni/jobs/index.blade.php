@extends('layouts.alumni')

@section('content')
<div class="directory-container">
    {{-- Recommended Jobs --}}
    @if(isset($recommendedJobs) && $recommendedJobs->count() > 0)
        <h2>Recommended Jobs for You</h2>
        <div class="job-list mb-4">
            @foreach($recommendedJobs as $job)
                <div class="job-card recommended" id="job-card-{{ $job->jobID }}">
                    <div class="job-card-body">
                        <div class="job-card-info">
                            <div class="badge-recommended">Recommended</div>
                            <h3>{{ $job->title }}</h3>
                            <p><i class="bi bi-building"></i> {{ $job->company ?? '-' }}</p>
                            <p><i class="bi bi-geo-alt"></i> {{ $job->location ?? '-' }}</p>
                            <p><i class="bi bi-tags"></i> {{ $job->category ?? '-' }}</p>
                            <p><i class="bi bi-person"></i> {{ $job->admin->name ?? '-' }}</p>
                        </div>
                        <div class="job-card-actions">
                            <button class="btn btn-outline-primary view-btn" 
                                onclick="window.location.href='{{ route('jobs.show', $job->jobID) }}'">
                                <i class="fas fa-eye me-1"></i> View
                            </button>
                            <button class="btn btn-outline-secondary btn-sm bookmark-btn" 
                                data-job="{{ $job->jobID }}">
                                <i class="bi {{ Auth::guard('alumni')->user()->bookmarkedJobs->contains($job->jobID) ? 'bi-bookmark-fill text-primary' : 'bi-bookmark' }}"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


    <h1>All Job Openings</h1>

    {{-- Buttons + Search/Filter --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap"
        style="margin-bottom: 2rem; position: relative; z-index: 10;">

        {{-- Left: Buttons --}}
        <div class="d-flex gap-2 flex-shrink-0">
            <button onclick="window.location='{{ route('jobs.bookmarked') }}'" class="btn btn-primary rounded-pill">
                <i class="bi bi-bookmark-fill me-1"></i> View Bookmarked Jobs
            </button>

            <button onclick="window.location='{{ route('jobs.pending') }}'" class="btn btn-secondary rounded-pill">
                <i class="bi bi-hourglass-split me-1"></i> View Pending Applications
            </button>
        </div>

        {{-- Right: Search + Filters --}}
        <form action="{{ route('jobs.index') }}" method="GET" class="d-flex gap-2 align-items-center flex-shrink-0">
            <input type="text" name="search" placeholder="Search jobs..." class="form-control search-input" value="{{ request('search') }}">

            <select name="category" class="form-select search-select" style="margin-top: .5rem; position: relative; z-index: 10;">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>

            <select name="location" class="form-select search-select">
                <option value="">All Locations</option>
                @foreach($allLocations as $location)
                    <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                        {{ $location }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary rounded-pill">
                <i class="bi bi-search me-1"></i> Search
            </button>
        </form>
    </div>

    {{-- Job List --}}
    <div class="job-list" id="allJobsList">
        @forelse($allJobs as $job)
            <div class="job-card" id="job-card-{{ $job->jobID }}">
                <div class="job-card-body">
                    <div class="job-card-info">
                        <h3>{{ $job->title }}</h3>
                        <p><i class="bi bi-building"></i> {{ $job->company ?? '-' }}</p>
                        <p><i class="bi bi-geo-alt"></i> {{ $job->location ?? '-' }}</p>
                        <p><i class="bi bi-tags"></i> {{ $job->category ?? '-' }}</p>
                        <p><i class="bi bi-person"></i> {{ $job->admin->name ?? '-' }}</p>
                    </div>
                    <div class="job-card-actions">
                        <button class="btn btn-outline-primary view-btn" 
                            onclick="window.location.href='{{ route('jobs.show', $job->jobID) }}'">
                            <i class="fas fa-eye me-1"></i> View
                        </button>
                        <button class="btn btn-outline-secondary btn-sm bookmark-btn" 
                            data-job="{{ $job->jobID }}">
                            <i class="bi {{ Auth::guard('alumni')->user()->bookmarkedJobs->contains($job->jobID) ? 'bi-bookmark-fill text-primary' : 'bi-bookmark' }}"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p>No job postings available.</p>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
window.addEventListener('load', function() {
    // Setup bookmark toggle
    document.querySelectorAll('.bookmark-btn').forEach(btn => {
        btn.onclick = function() {
            const jobID = this.dataset.job;
            const icon = this.querySelector('i');

            axios.post(`/jobs/${jobID}/bookmark`, {}, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            }).then(res => {
                if(res.data.status === 'added'){
                    icon.classList.remove('bi-bookmark');
                    icon.classList.add('bi-bookmark-fill','text-primary');
                } else {
                    icon.classList.remove('bi-bookmark-fill','text-primary');
                    icon.classList.add('bi-bookmark');
                }
            }).catch(err => console.error(err));
        }
    });
});
</script>
@endpush

<style>
/* Recommended Badge */
.badge-recommended {
    display: inline-block;
    background-color: #ffc107;
    color: #212529;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 12px;
    margin-bottom: 6px;
}
.job-card.recommended {
    border: 2px solid #ffc107;
}
.directory-container { padding: 2rem 1rem; }
.btn-primary, .btn-outline-primary, .btn-secondary { 
    border-radius: 50px; 
    font-weight: 500; 
    padding: 8px 20px; 
    cursor: pointer; 
}
.d-flex.gap-2 > .btn { min-width: 200px; }

.search-form { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.search-input {
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 25px;
    outline: none;
    width: 220px;
    transition: border-color 0.3s ease;
}
.search-input:focus { border-color: #007bff; }
.search-select {
    padding: 10px;
    border-radius: 25px;
    border: 1px solid #ccc;
    outline: none;
    width: 160px;
    transition: border-color 0.3s ease;
}
.search-select:focus { border-color: #007bff; }

.job-list { display: flex; flex-direction: column; gap: 1.5rem; }
.job-card { background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.2s, box-shadow 0.2s; }
.job-card:hover { transform: translateY(-4px); box-shadow: 0 6px 16px rgba(0,0,0,0.12); }
.job-card-body { padding: 1rem; display: flex; flex-direction: column; justify-content: space-between; height: 100%; }
.job-card-info h3 { margin-bottom: 0.5rem; font-size: 1.25rem; color: #333; }
.job-card-info p { margin: 0.2rem 0; color: #555; font-size: 0.95rem; }
.job-card-info i { margin-right: 0.3rem; color: #777; }
.job-card-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
.bookmark-btn i { font-size: 1.2rem; transition: color 0.2s; }
.bookmark-btn:hover i { color: #007bff; }
.view-btn { border-radius: 25px; padding: 6px 16px; font-weight: 500; display: flex; align-items: center; gap: 4px; }
</style>
@endsection
