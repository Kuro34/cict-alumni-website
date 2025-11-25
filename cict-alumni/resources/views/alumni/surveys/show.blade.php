@extends('layouts.alumni')

@section('content')
<style>
    .survey-details-container {
        padding: 20px;
        max-width: 900px;
        margin: auto;
    }

    .survey-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        transition: transform 0.2s;
        padding: 25px;
    }

    .survey-card h2 {
        font-size: 1.8rem;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .survey-meta {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 15px;
    }

    .survey-meta i {
        margin-right: 5px;
        color: #0d6efd;
    }

    .survey-description {
        font-size: 1rem;
        margin-bottom: 20px;
    }
    .btn-outline-primary { border-radius: 50px; font-weight: 500; padding: 8px 20px; cursor: pointer; margin-bottom:20px; }

    iframe {
        border: none;
        border-radius: 10px;
        width: 100%;
        min-height: 600px;
        display: none; /* hidden until start */
    }

    #done-btn {
        margin-top: 15px;
        display: none; /* hidden until start */
    }

    #timer-text {
        display: none; /* hidden until start */
    }

    /* Warning message */
    .survey-warning {
        margin-top: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        color: #d9534f; /* bootstrap danger red */
        text-align: center;
    }
</style>

<div class="survey-details-container">
    <button class="btn btn-outline-primary btn-job-action mb-3" onclick="window.location.href='{{ route('alumni.surveys.index') }}'">
        <i class="bi bi-arrow-left-circle me-1"></i> Back to Events
    </button>

    <div class="survey-card">
        <h2>{{ $survey->title }}</h2>
        <p class="survey-meta">
            📝 Created: {{ $survey->created_at->format('M d, Y') }} <br>
            ⏳ Ends: {{ \Carbon\Carbon::parse($survey->end_date)->format('M d, Y') }} <br>
            ⭐ {{ $survey->points }} pts <br>
            ⏱️ Duration: {{ $survey->expected_duration }} mins
        </p>

        <p class="survey-description">{{ $survey->description }}</p>

        {{-- Show Start Survey button only if not already submitted --}}
        @if(!$alreadyCompleted)
            <div class="text-center" id="start-container">
                <button id="start-btn" class="btn btn-outline-primary btn-job-action mb-3">
                    <i class="bi bi-play-circle"></i> Start Survey
                </button>
            </div>
        @else
            <p class="text-success text-center fw-bold">✅ You have already completed this survey.</p>
        @endif

        {{-- Embed Google Form --}}
        @if($survey->form_url)
            <iframe id="survey-frame" src="{{ $survey->form_url }}?embedded=true">
                Loading…
            </iframe>

            {{-- Timer + Done Button --}}
            <div class="text-center">
                <p id="timer-text" class="mt-3 text-muted"></p>
                <button id="done-btn" class="btn btn-success" disabled>
                    I’m Done
                </button>
            </div>

            {{-- ⚠️ Warning message --}}
            <p class="survey-warning">
                ⚠️ Submitting blank or invalid responses will result in point deduction.
            </p>
        @else
            <p class="text-danger">No form link available for this survey.</p>
        @endif
    </div>
</div>

<script>
    let duration = {{ $survey->expected_duration ?? 5 }} * 60; 
    let doneBtn = document.getElementById("done-btn");
    let timerText = document.getElementById("timer-text");
    let surveyFrame = document.getElementById("survey-frame");
    let startBtn = document.getElementById("start-btn");
    let surveyKey = "survey_timer_{{ $survey->surveyID }}";

    function startTimer(seconds) {
        let endTime = localStorage.getItem(surveyKey);

        if (!endTime) {
            endTime = Date.now() + (seconds * 1000);
            localStorage.setItem(surveyKey, endTime);
        } else {
            endTime = parseInt(endTime);
        }

        let interval = setInterval(() => {
            let remaining = Math.floor((endTime - Date.now()) / 1000);

            if (remaining > 0) {
                let min = Math.floor(remaining / 60);
                let sec = remaining % 60;
                timerText.textContent = `You can confirm in ${min}:${sec < 10 ? "0" : ""}${sec}`;
            } else {
                clearInterval(interval);
                doneBtn.disabled = false;
                timerText.textContent = "You can now confirm completion.";
                localStorage.removeItem(surveyKey);
            }
        }, 1000);
    }

    // Start button click
    if (startBtn) {
        startBtn.addEventListener("click", function() {
            surveyFrame.style.display = "block";
            doneBtn.style.display = "inline-block";
            timerText.style.display = "block";
            startBtn.style.display = "none"; // hide start button
            startTimer(duration);
        });
    }

    // Handle Done button
    if (doneBtn) {
        doneBtn.addEventListener("click", function() {
            fetch("{{ route('alumni.surveys.confirm', $survey->surveyID) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    alert("Survey completion recorded! You earned {{ $survey->points }} points 🎉");
                    doneBtn.disabled = true;
                    doneBtn.textContent = "Completed";
                    if (document.getElementById("start-container")) {
                        document.getElementById("start-container").style.display = "none";
                    }
                }
            });
        });
    }
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
