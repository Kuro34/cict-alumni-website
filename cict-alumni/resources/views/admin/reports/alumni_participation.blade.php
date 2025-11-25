@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">📊 Alumni Report</h1>

    <div class="row g-4 mb-4">
        <!-- Gender Chart Card -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    Gender Distribution
                </div>
                <div class="card-body">
                    <canvas id="genderChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Age Chart Card -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    Age Distribution
                </div>
                <div class="card-body">
                    <canvas id="ageChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Degree Program Chart Card -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    Degree Programs
                </div>
                <div class="card-body">
                    <canvas id="degreeChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Alumni Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Alumni Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Degree Program</th>
                    <th>Graduation Year</th>
                    <th>Events Attended</th>
                    <th>Surveys Completed</th>
                    <th>Total Points Earned</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumni as $index => $al)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $al->first_name }} {{ $al->middle_initial ? $al->middle_initial.'.' : '' }} {{ $al->last_name }}</td>
                        <td class="text-center">{{ $al->gender ?? 'Not specified' }}</td>
                        <td class="text-center">{{ $al->age ?? '-' }}</td>
                        <td>{{ $al->degree_program ?? '-' }}</td>
                        <td class="text-center">{{ $al->graduation_year ?? '-' }}</td>
                        <td class="text-center">{{ $al->eventRegistrations->count() }}</td>
                        <td class="text-center">{{ $al->surveyResponses->where('completed', 1)->count() }}</td>
                        <td class="text-center">{{ $al->total_points }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No alumni found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.reports.alumni.export') }}" class="btn btn-success mb-3">
            Export CSV
        </a>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ------------------------
    // Gender Chart
    // ------------------------
    let genderCountsRaw = @json($alumni->groupBy('gender')->map->count());

    // Replace empty/null with "Not specified"
    let genderCounts = {};
    Object.keys(genderCountsRaw).forEach(k => {
        let label = k && k.trim() ? k : 'Not specified';
        genderCounts[label] = genderCountsRaw[k];
    });

    // Sort labels consistently
    const orderedGenderLabels = ['Male', 'Female', 'Other', 'Prefer not to say', 'Not specified'];
    let sortedGenderCounts = {};
    orderedGenderLabels.forEach(label => {
        if(genderCounts[label]) sortedGenderCounts[label] = genderCounts[label];
    });
    // Append any remaining
    Object.keys(genderCounts).forEach(label => {
        if(!sortedGenderCounts[label]) sortedGenderCounts[label] = genderCounts[label];
    });

    const genderLabels = Object.keys(sortedGenderCounts);
    const genderData = Object.values(sortedGenderCounts);

    new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: {
            labels: genderLabels,
            datasets: [{
                label: 'Alumni by Gender',
                data: genderData,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(201, 203, 207, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(201, 203, 207, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    // ------------------------
    // Age Chart
    // ------------------------
    const ageCounts = {};
    @foreach($alumni as $al)
        @if($al->age)
            ageCounts[{{ $al->age }}] = (ageCounts[{{ $al->age }}] || 0) + 1;
        @endif
    @endforeach
    const ageLabels = Object.keys(ageCounts);
    const ageData = Object.values(ageCounts);

    new Chart(document.getElementById('ageChart'), {
        type: 'bar',
        data: {
            labels: ageLabels,
            datasets: [{
                label: 'Number of Alumni',
                data: ageData,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // ------------------------
    // Degree Program Chart
    // ------------------------
    const degreeCountsRaw = @json($alumni->groupBy('degree_program')->map->count());
    const degreeCounts = {};
    Object.keys(degreeCountsRaw).forEach(k => {
        let label = k && k.trim() ? k : 'Not specified';
        degreeCounts[label] = degreeCountsRaw[k];
    });
    const degreeLabels = Object.keys(degreeCounts);
    const degreeData = Object.values(degreeCounts);

    new Chart(document.getElementById('degreeChart'), {
        type: 'bar',
        data: {
            labels: degreeLabels,
            datasets: [{
                label: 'Number of Alumni',
                data: degreeData,
                backgroundColor: 'rgba(153, 102, 255, 0.7)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection
