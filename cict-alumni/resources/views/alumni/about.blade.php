@extends('layouts.alumni')

@section('content')
<div class="container py-5">
<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 py-5">
    <h1 class="mb-5 text-center">About</h1>
</div>
    <!-- Bulacan State University Section -->
    <div class="mb-5">
        <h2 class="mb-4 text-center">Bulacan State University</h2>
        <div class="row justify-content-center g-4 text-center">

            <!-- Vision Card -->
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-sm border-0 h-100 p-4 mx-auto">
                    <i class="fas fa-eye fa-3x text-primary mb-3 d-block mx-auto"></i>
                    <h4 class="card-title mb-3">Vision</h4>
                    <p class="card-text">
                        Bulacan State University is a progressive knowledge-generating institution<br>
                        globally recognized for excellent instruction,<br>
                        pioneering research, and responsive community engagements.
                    </p>
                </div>
            </div>

            <!-- Mission Card -->
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-sm border-0 h-100 p-4 mx-auto">
                    <i class="fas fa-bullseye fa-3x text-success mb-3 d-block mx-auto"></i>
                    <h4 class="card-title mb-3">Mission</h4>
                    <p class="card-text">
                        Bulacan State University exists to produce highly competent,<br>
                        ethical and service-oriented professionals<br>
                        that contribute to the sustainable socio-economic growth and development of the nation.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- BulSU CICT Section -->
    <div class="mb-5">
        <h2 class="mb-4 text-center">BulSU CICT</h2>
        <div class="row justify-content-center g-4 text-center">

            <!-- Mission Card -->
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-sm border-0 h-100 p-4 mx-auto">
                    <i class="fas fa-bullseye fa-3x text-success mb-3 d-block mx-auto"></i>
                    <h4 class="card-title mb-3">Mission</h4>
                    <p class="card-text">
                        Bulacan State University is a progressive knowledge-generating institution<br>
                        globally recognized for excellent instruction,<br>
                        pioneering research, and responsive community engagements.
                    </p>
                </div>
            </div>

            <!-- Vision Card -->
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-sm border-0 h-100 p-4 mx-auto">
                    <i class="fas fa-eye fa-3x text-primary mb-3 d-block mx-auto"></i>
                    <h4 class="card-title mb-3">Vision</h4>
                    <p class="card-text">
                        Bulacan State University exists to provide highly competent,<br>
                        ethical and service-oriented professionals<br>
                        that contribute to the sustainable socio-economic growth and development of the nation.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .card {
        max-width: 400px;
        border-radius: 12px;
        background-color: #fff;
        transition: transform 0.2s, box-shadow 0.2s;
        margin: 0 auto;
        text-align: center;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08);
    }

    .card-title {
        font-weight: 700;
        color: #222;
    }

    h2 {
        font-weight: 700;
        color: #333;
        text-align: center; /* explicitly center headings */
    }

    .card-text {
        color: #555;
        font-size: 1rem;
        line-height: 1.6;
        text-align: center;
    }

    .text-primary { color: #0d6efd; } /* Vision icon */
    .text-success { color: #198754; } /* Mission icon */
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap-grid.min.css" rel="stylesheet">
@endsection
