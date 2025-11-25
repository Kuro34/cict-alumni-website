@extends('layouts.alumni')

@section('content')
<style>
    .surveys-container h1 {
        margin-bottom: 30px;
        font-weight: 700;
        text-align: center;
    }

    .survey-card {
        margin-bottom: 20px;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }

    .survey-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .survey-card-body {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 16px;
    }

    .survey-card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .survey-card-text {
        flex: 1;
        color: #555;
        margin-bottom: 12px;
    }

    .survey-card-meta {
        font-size: 0.9rem;
        color: #777;
        margin-bottom: 12px;
    }

    .take-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 8px;
        text-decoration: none;
        color: #000000;
        background-color: #fff;
        border: none;
        transition: transform 0.2s, box-shadow 0.2s;
        align-self: flex-start;
    }

    .take-btn:hover {
        background-color: rgb(187, 192, 198);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .take-btn i {
        font-size: 0.95rem;
    }

    @media (max-width: 767px) {
        .surveys-container {
            padding: 15px;
        }
    }
</style>

<div class="surveys-container" style="max-width: 1200px; margin: auto; padding: 20px;">
    <h1>Available Surveys</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4 mt-3">
        @forelse($surveys as $survey)
            <div class="col-md-4 col-sm-6">
                <div class="card survey-card h-100">
                    <div class="survey-card-body">
                        <h5 class="survey-card-title">{{ $survey->title }}</h5>
                        <p class="survey-card-text text-truncate">{{ $survey->description }}</p>
                        
                        <p class="survey-card-meta">
                            📝 Created: {{ $survey->created_at->format('M d, Y') }} <br>
                            ⏳ Ends: {{ \Carbon\Carbon::parse($survey->end_date)->format('M d, Y') }} <br>
                            @if($survey->expected_duration)
                                ⏱️ Duration: {{ $survey->expected_duration }} mins
                            @endif
                        </p>

                        <div class="card-footer text-end text-muted small" style="margin-bottom: 10px;">
                            <i class="bi bi-star-fill text-warning"></i> {{ $survey->points }} pts
                        </div>

                        {{-- Open Survey Show page --}}
                        <a href="{{ route('alumni.surveys.show', $survey->surveyID) }}" class="take-btn mt-auto">
                            <i class="bi bi-pencil-square"></i> Take Survey
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No surveys available at the moment.</p>
        @endforelse
    </div>
</div>
@endsection
