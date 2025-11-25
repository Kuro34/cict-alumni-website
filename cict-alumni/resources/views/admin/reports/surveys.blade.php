@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">📊 Surveys Report</h1>
    
        <!-- 📊 Participation Rate Chart -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    Survey Participation Rate (%)
                </div>
                <div class="card-body">
                    <canvas id="surveyParticipationChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Survey Title</th>
                    <th>Organizer</th>
                    <th>Responses</th>
                    <th>Participation Rate (%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surveys as $index => $survey)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $survey->title }}</td>
                        <td>{{ $survey->organizer ?? 'N/A' }}</td>
                        <td class="text-center">{{ $survey->responses_count }}</td>
                        <td class="text-center">{{ $survey->participation_rate }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No surveys found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.reports.surveys.export') }}" class="btn btn-success mb-3">
            Export CSV
        </a>
    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const surveyLabels = @json($surveys->pluck('title'));
    const participationData = @json($surveys->pluck('participation_rate'));

    new Chart(document.getElementById('surveyParticipationChart'), {
        type: 'bar',
        data: {
            labels: surveyLabels,
            datasets: [{
                label: 'Participation Rate (%)',
                data: participationData,
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
                    title: { display: true, text: 'Survey' }
                }
            }
        }
    });
</script>
@endsection
