@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">📅 Events Report</h1>

    <!-- 📊 Participation Rate Chart Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    Event Participation Rate (%)
                </div>
                <div class="card-body">
                    <canvas id="eventParticipationChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Organizer</th>
                    <th>Date</th>
                    <th>Registrations</th>
                    <th>Participation Rate (%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $index => $event)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->organizer ?? 'N/A' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}</td>
                        <td class="text-center">{{ $event->participants_count }}</td>
                        <td class="text-center">{{ $event->participation_rate }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No events found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.reports.events.export') }}" class="btn btn-success mb-3">
            Export CSV
        </a>
    </div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const eventLabels = @json($events->pluck('title'));
    const eventParticipationData = @json($events->pluck('participation_rate'));

    new Chart(document.getElementById('eventParticipationChart'), {
        type: 'bar',
        data: {
            labels: eventLabels,
            datasets: [{
                label: 'Participation Rate (%)',
                data: eventParticipationData,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: { display: true, text: 'Participation Rate (%)' }
                },
                x: {
                    title: { display: true, text: 'Event' }
                }
            }
        }
    });
</script>
@endsection
