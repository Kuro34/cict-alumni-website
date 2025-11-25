@extends('layouts.alumni')

@section('content')
<div class="directory-container">
    <h1>Bookmarked Jobs</h1>
    <button onclick="window.location='{{ route('jobs.index') }}'" class="btn btn-primary rounded-pill mb-4" style="margin-bottom: 2rem; position: relative; z-index: 10;">
        <i class="bi bi-arrow-left me-1"></i> Back to All Jobs
    </button>

    <div class="job-list" id="bookmarkedJobsList">
        @forelse($bookmarkedJobs as $job)
            <div class="job-card" id="job-card-{{ $job->jobID }}">
                <div class="job-card-body">
                    <div class="job-card-info">
                        <h3>{{ $job->title }}</h3>
                        <p><i class="bi bi-building"></i> {{ $job->company ?? '-' }}</p>
                        <p><i class="bi bi-geo-alt"></i> {{ $job->location ?? '-' }}</p>
                        <p><i class="bi bi-person"></i> {{ $job->admin->name ?? '-' }}</p>
                    </div>
                    <div class="job-card-actions">
                        <a href="{{ route('jobs.show', $job->jobID) }}" class="btn btn-outline-primary view-btn">
                            <i class="fas fa-eye me-1"></i> View
                        </a>
                        <button class="btn btn-outline-secondary btn-sm bookmark-btn" data-job="{{ $job->jobID }}">
                            <i class="bi bi-bookmark-fill text-primary"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p id="no-bookmarked">You have no bookmarked jobs.</p>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
function setupBookmarkButtons() {
    document.querySelectorAll('.bookmark-btn').forEach(btn => {
        btn.onclick = function() {
            const jobID = this.dataset.job;
            const icon = this.querySelector('i');

            axios.post(`/jobs/${jobID}/bookmark`, {}, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            }).then(res => {
                if(res.data.status === 'removed'){
                    const card = document.getElementById(`job-card-${jobID}`);
                    if(card) card.remove();

                    if(document.getElementById('bookmarkedJobsList').children.length === 0){
                        document.getElementById('bookmarkedJobsList').innerHTML = '<p id="no-bookmarked">You have no bookmarked jobs.</p>';
                    }
                }
            }).catch(err => console.error(err));
        }
    });
}

window.onload = setupBookmarkButtons;
</script>
@endpush

<style>
.directory-container { padding: 4rem 1rem 2rem 1rem; }
.btn-primary, .btn-outline-primary { border-radius: 50px; font-weight: 500; padding: 8px 20px; cursor: pointer; }
.job-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
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
