@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4 fw-bold text-primary">Dashboard Overview</h2>

    {{-- Summary Cards --}}
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-secondary">Total Alumni</h6>
                    <h2 class="fw-bold text-primary">{{ $alumniCount ?? '0' }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-secondary">Events</h6>
                    <h2 class="fw-bold text-primary">{{ $eventCount ?? '0' }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-secondary">Job Posts</h6>
                    <h2 class="fw-bold text-primary">{{ $jobCount ?? '0' }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-secondary">Surveys</h6>
                    <h2 class="fw-bold text-primary">{{ $surveyCount ?? '0' }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Second Row --}}
    <div class="row g-4 mt-3">
        {{-- Raffles --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-secondary">Raffles</h6>
                    <h2 class="fw-bold text-primary">{{ $raffleCount ?? '0' }}</h2>
                    <p class="small text-muted mb-0">&nbsp;</p>
                </div>
            </div>
        </div>

        {{-- Currently Online Alumni --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-secondary">Currently Online</h6>
                    <h2 class="fw-bold text-primary" id="onlineCount">
                        {{ $onlineAlumniCount ?? '0' }}
                    </h2>
                    <p class="small text-muted mb-0">(Active within last 5 mins)</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    function fetchOnlineCount() {
        fetch('{{ route('admin.online.count') }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            const elem = document.getElementById('onlineCount');
            if (elem) elem.textContent = data.count;
        })
        .catch(err => console.error('Error fetching online count:', err));
    }

    // Fetch immediately, then every 10 seconds
    fetchOnlineCount();
    setInterval(fetchOnlineCount, 10000);
});
</script>
@endsection
