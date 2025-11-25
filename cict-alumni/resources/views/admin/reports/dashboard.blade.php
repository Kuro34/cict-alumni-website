@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">📊 Reports Dashboard</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Alumni</h5>
                    <p class="card-text fs-3">{{ $totalAlumni }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Events</h5>
                    <p class="card-text fs-3">{{ $totalEvents }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Surveys</h5>
                    <p class="card-text fs-3">{{ $totalSurveys }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Rewards</h5>
                    <p class="card-text fs-3">{{ $totalRewards }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Raffles</h5>
                    <p class="card-text fs-3">{{ $totalRaffles }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
