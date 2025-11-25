@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.alumni.index') }}" class="btn btn-secondary mb-3">← Back</a>

    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <img src="{{ asset('storage/' . $alumni->profile_picture) }}" 
                 onerror="this.src='{{ asset('images/default-avatar.png') }}';"
                 width="120" height="120" class="rounded-circle mb-3">

            <h4><strong>Name:</strong> {{ $alumni->first_name }} {{ $alumni->last_name }}</h4>
            <p><strong>Email:</strong> {{ $alumni->email }}</p>
            <p><strong>Course:</strong> {{ $alumni->degree_program }}</p>
            <p><strong>Batch:</strong> {{ $alumni->graduation_year }}</p>
            <p><strong>Points:</strong> {{ $totalPoints ?? 0 }}</p>

            <!-- Adjust Points Button -->
            <button type="button" class="btn btn-sm btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#adjustPointsModal">
                Adjust Points
            </button>
            
            <!-- Adjust Points Modal -->
            <div class="modal fade" id="adjustPointsModal" tabindex="-1" aria-labelledby="adjustPointsLabel" aria-hidden="true">
              <div class="modal-dialog">
                <form method="POST" action="{{ route('admin.alumni.adjustPoints', $alumni->alumniID) }}">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="adjustPointsLabel">Adjust Points for {{ $alumni->first_name }} {{ $alumni->last_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                            <div class="mb-3">
                                <label for="points" class="form-label">Points (+ to add, - to reduce)</label>
                                <input type="number" name="points" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <input type="text" name="reason" class="form-control" placeholder="E.g., Event participation bonus" required>
                            </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>

    <!-- Point Adjustment History -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Point Adjustment History (Latest 10)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Points Changed</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pointHistory as $point)
                            <tr>
                                <td>{{ $point->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ $point->points_changed }}</td>
                                <td>{{ $point->reason ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No point adjustments yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
