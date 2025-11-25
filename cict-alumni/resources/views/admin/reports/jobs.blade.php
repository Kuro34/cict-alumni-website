@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">💼 Job Postings Report</h1>
    
        <!-- 📊 Application Rate Chart -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        Job Application Rate (%)
                    </div>
                    <div class="card-body">
                        <canvas id="jobApplicationChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Category</th>
                    <th>Posted By</th>
                    <th>Applications</th>
                    <th>Application Rate (%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $index => $job)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $job->title }}</td>
                        <td>{{ $job->company }}</td>
                        <td>{{ $job->category }}</td>
                        <td>{{ $job->admin->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $job->applications_count }}</td>
                        <td class="text-center">{{ $job->application_rate ?? 0 }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No jobs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.reports.jobs.export') }}" class="btn btn-success mb-3">
            Export CSV
        </a>
    </div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const jobLabels = @json($jobs->pluck('title'));
    const applicationData = @json($jobs->pluck('application_rate'));

    new Chart(document.getElementById('jobApplicationChart'), {
        type: 'bar',
        data: {
            labels: jobLabels,
            datasets: [{
                label: 'Application Rate (%)',
                data: applicationData,
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
                    title: { display: true, text: 'Application Rate (%)' }
                },
                x: {
                    title: { display: true, text: 'Job Title' }
                }
            }
        }
    });
</script>
@endsection
