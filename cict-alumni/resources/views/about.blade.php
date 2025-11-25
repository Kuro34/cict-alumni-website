<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | CICT Alumni Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
/* ---------- Base ---------- */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
body {
            padding-top: 116px; /* desktop */
        }
        
        @media (max-width: 767px) {
            body {
                padding-top: 100px; /* mobile */
            }
        }

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
    z-index: 10001 !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    margin: 0;
    box-sizing: border-box;
}

.top-header img {
    height: 50px;
    width: 50px;
    object-fit: contain;
}

.top-header h6 {
    margin: 0;
    font-size: 0.85rem;
    color: #dbeafe;
}

.top-header .right a {
    color: white;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s;
    margin-left:10px ;
}

.top-header .right a:hover {
    color: #93c5fd;
}

.header-hamburger {
    border: none !important;
    background: none !important;
    padding: 4px 8px !important;
    display: none !important;
}

.header-hamburger:focus {
    box-shadow: none !important;
}

.header-hamburger-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    width: 24px !important;
    height: 24px !important;
    display: inline-block;
}

/* ---------- Navbar ---------- */
#fixed-navbar-container {
    position: fixed !important;
    top: 60px !important;
    left: 0 !important;
    width: 100% !important;
    z-index: 10000 !important;
    background-color: #3b82f6 !important;
    box-sizing: border-box;
    transition: all 0.3s ease !important;
}

.navbar-nav .nav-link {
    color: white !important;
    font-weight: 500;
}

.navbar-nav .nav-link:hover {
    color: #dbeafe !important;
}

.dropdown-menu {
    background-color: #3b82f6;
    border: none;
}

.dropdown-menu a {
    color: white !important;
}

.dropdown-menu a:hover {
    background-color: #2563eb;
}

/* ---------- Responsive ---------- */
@media (max-width: 767px) {
    #fixed-navbar-container {
        top: 48px !important;
        background-color: #1e3a8a !important;
        transform: translateY(-100%);
    }

    #fixed-navbar-container.show {
        transform: translateY(0) !important;
    }

    .navbar-collapse {
        background-color: #1e3a8a !important;
        width: 100vw !important;
        margin: 0 !important;
        padding: 0 !important;
        position: relative !important;
    }

    .navbar-nav {
        text-align: left !important;
        padding: 20px !important;
        width: 100% !important;
    }

    .nav-link {
        display: block !important;
        padding: 15px 20px !important;
        text-align: left !important;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        font-size: 1rem !important;
    }

    .dropdown-menu {
        padding-left: 40px !important;
        background-color: #2563eb !important;
        border: none !important;
        margin: 0 !important;
        position: static !important;
        width: 100% !important;
    }

    .dropdown-item {
        padding: 10px 20px !important;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .header-hamburger {
        display: block !important;
    }

    .top-header h5,
    .top-header h6,
    .top-header .right {
        display: none !important;
    }

    .top-header img {
        height: 40px;
        width: 40px;
    }

    .top-header {
        padding: 8px 15px !important;
        min-height: 48px !important;
    }

    .content-offset {
        height: 104px !important;
    }
}

.content-offset {
    height: 116px;
}

/* ---------- Cards ---------- */
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
    text-align: center;
}

.card-text {
    color: #555;
    font-size: 1rem;
    line-height: 1.6;
    text-align: center;
}

.text-primary { color: #0d6efd; }
.text-success { color: #198754; }
/* ---------- Sections ---------- */
.announcement-section,
.contact-section,
.news-section {
    background-color: #f1f5f9;
    padding: 80px 0 40px;
    margin-bottom: 0 !important;
    width: 100%;
}

/* ---------- Footer ---------- */
footer {
    background-color: #1e3a8a;
    color: white;
    padding: 30px 0;
    text-align: center;
    font-size: 0.9rem;
    margin-top: auto !important;
    width: 100%;
    margin-bottom: 0 !important; /* FIX: Removes white space */
}

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
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.about') }}">About</a></li>

                    <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('alumni.login') }}"><i class="fa-solid fa-right-to-bracket me-1"></i> Login</a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('alumni.register') }}"><i class="fa-solid fa-user-plus me-1"></i> Register</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="content-offset"></div>

<!-- ---------- About Content ---------- -->
<section class="container py-5">
    <div class="d-flex flex-column justify-content-center align-items-center py-5">
        <h1 class="mb-5 text-center">About</h1>
    </div>

    <!-- Bulacan State University Section -->
    <div class="mb-5">
        <h2 class="mb-4">Bulacan State University</h2>
        <div class="row justify-content-center g-4 text-center">

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
        <h2 class="mb-4">BulSU CICT</h2>
        <div class="row justify-content-center g-4 text-center">

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
</section>

<!-- ---------- Footer ---------- -->
<footer class="text-center mt-auto py-3 bg-primary text-white">
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
