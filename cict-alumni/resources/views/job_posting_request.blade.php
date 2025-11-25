<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Posting Request | CICT Alumni Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* ---------- Base ---------- */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            overflow-x: hidden;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 116px; /* desktop */
        }
        @media (max-width: 767px) {
            body { padding-top: 100px; }
        }
        .content-offset { height: 116px; }
        
        /* ---------- Header ---------- */
        .top-header {
            background-color: #1e3a8a;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 10001;
        }
        .top-header img { height: 50px; width: 50px; object-fit: contain; }
        .top-header h6 { margin: 0; font-size: 0.85rem; color: #dbeafe; }
        .top-header .right a { color: white; font-weight: 600; text-decoration: none; margin-left: 10px; }
        .top-header .right a:hover { color: #93c5fd; }
        .header-hamburger { border: none; background: none; padding: 4px 8px; display: none; }
        .header-hamburger-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 24px;
            height: 24px;
            display: inline-block;
        }

        /* ---------- Fixed Navbar ---------- */
        #fixed-navbar-container {
            position: fixed;
            top: 60px;
            left: 0;
            width: 100%;
            z-index: 10000;
            background-color: #3b82f6;
            transition: all 0.3s ease;
        }
        .navbar-nav .nav-link { color: white; font-weight: 500; font-size: 1rem; }
        .navbar-nav .nav-link:hover { color: #dbeafe; }
        .dropdown-menu { background-color: #3b82f6; border: none; }
        .dropdown-menu a { color: white !important; font-size: 1rem; }
        .dropdown-menu a:hover { background-color: #2563eb; }

        @media (max-width: 767px) {
            #fixed-navbar-container { top: 48px; background-color: #1e3a8a; transform: translateY(-100%); }
            #fixed-navbar-container.show { transform: translateY(0); }
            .navbar-collapse { background-color: #1e3a8a; width: 100vw; padding: 0; }
            .navbar-nav { text-align: left; padding: 20px; width: 100%; }
            .nav-link { display: block; padding: 15px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
            .dropdown-menu { padding-left: 40px; background-color: #2563eb; position: static; width: 100%; }
            .header-hamburger { display: block; }
        }

        /* ---------- Sections ---------- */
        .job-request-section { background-color: #f1f5f9; padding: 80px 0 40px; }
        .job-request-section h2 { font-weight: 700; margin-bottom: 1rem; }
        .job-request-section h5 { color: #6b7280; margin-bottom: 2rem; }

        /* ---------- Footer ---------- */
        footer { background-color: #1e3a8a; color: white; padding: 30px 0; text-align: center; font-size: 0.9rem; margin-top: auto; }
    </style>
</head>
<body>

<!-- ---------- Header ---------- -->
<header class="top-header">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <img src="/images/logo1.png" alt="Logo 1">
            <img src="/images/logo2.png" alt="Logo 2">
            <div class="header-text d-none d-md-block">
                <h6 class="mb-0">College of Information and Communications Technology</h6>
                <h6 class="mb-0">Bulacan State University</h6>
                <h6 class="mb-0">CICT Alumni Management System</h6>
            </div>
        </div>

        <div class="right d-none d-md-flex">
            <a href="{{ route('alumni.register') }}"><i class="fa-solid fa-user-plus me-1"></i> Register</a>
            <a href="{{ route('alumni.login') }}"><i class="fa-solid fa-right-to-bracket me-1"></i> Login</a>
        </div>
        
        <button class="header-hamburger d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="header-hamburger-icon"></span>
        </button>
    </div>
</header>

<!-- ---------- FIXED NAVBAR ---------- -->
<div id="fixed-navbar-container">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav w-100 d-flex justify-content-around text-center">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('landing') }}">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Careers</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('job-posting-request.create') }}">Job Posting Request Form</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Events</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a class="nav-link" href="{{ route('public.events') }}">Events</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="dropdown">Gallery</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('gallery') }}">Gallery</a></li>
                            <li><a class="dropdown-item" href="{{ route('featured-alumni') }}">Featured Alumni</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('alumni.about') ? 'active' : '' }}" href="{{ route('alumni.about') }}">About</a></li>

                    <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('alumni.login') }}"><i class="fa-solid fa-right-to-bracket me-1"></i> Login</a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('alumni.register') }}"><i class="fa-solid fa-user-plus me-1"></i> Register</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="content-offset"></div>
<!-- ---------- Job Posting Request Form ---------- -->
<section class="job-request-section">
    <div class="container">
        <h2 class="text-center">Job Posting Request Form</h2>
        <h5 class="text-center">Submit your company's job posting request to reach our CICT alumni.</h5>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ route('job-posting-request.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required>
                        @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Email</label>
                        <input type="email" name="company_email" class="form-control @error('company_email') is-invalid @enderror" value="{{ old('company_email') }}" required>
                        @error('company_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Address</label>
                        <input type="text" name="company_address" class="form-control @error('company_address') is-invalid @enderror" value="{{ old('company_address') }}" required>
                        @error('company_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number') }}" required>
                        @error('contact_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Person</label>
                        <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person') }}" required>
                        @error('contact_person')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Website</label>
                        <input type="url" name="company_website" class="form-control @error('company_website') is-invalid @enderror" value="{{ old('company_website') }}">
                        @error('company_website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit Request</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ---------- Footer ---------- -->
<footer class="text-center">
    <small>Bulacan State University © {{ date('Y') }} |
        <a href="{{ route('admin.login') }}" class="text-light text-decoration-none">Admin Login</a>
    </small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const hamburger = document.querySelector('.header-hamburger');
        const navbarContainer = document.getElementById('fixed-navbar-container');
        if (hamburger) {
            hamburger.addEventListener('click', function() {
                navbarContainer.classList.toggle('show');
            });
        }
        document.addEventListener('click', function(event) {
            const isClickInsideNavbar = navbarContainer.contains(event.target);
            const isClickOnHamburger = hamburger && hamburger.contains(event.target);
            if (!isClickInsideNavbar && !isClickOnHamburger && window.innerWidth <= 767) {
                navbarContainer.classList.remove('show');
            }
        });
    });
</script>

</body>
</html>
