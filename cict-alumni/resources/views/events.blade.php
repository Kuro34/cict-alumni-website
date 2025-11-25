<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events | CICT Alumni Management System</title>

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
            margin-left: 10px;
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

        /* ---------- FIXED NAVBAR ---------- */
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
            font-size: 1rem;
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
            font-size: 1rem;
        }

        .dropdown-menu a:hover {
            background-color: #2563eb;
        }

        /* ---------- MOBILE NAVBAR OVERRIDE ---------- */
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

            .navbar-nav.d-flex {
                display: none !important;
            }

            .navbar-collapse.show .navbar-nav.d-flex {
                display: flex !important;
                flex-direction: column !important;
            }

            .header-hamburger { display: block !important; }
        }

        /* Content offset so page doesn't hide behind fixed header */
        .content-offset { height: 116px; }

        /* ---------- MODAL FIX ---------- */
        .modal {
            z-index: 10550 !important; /* above fixed navbar */
        }
        
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

<!-- ---------- FIXED HEADER ---------- -->
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

<!-- ---------- Events Section ---------- -->
<section class="announcements container my-5 announcement-section">
    <h2 class="fw-bold mb-4 text-center">Upcoming Events</h2>
    <h5 class="fw mb-4 text-center">Check out the upcoming events. Login to register for an event.</h5>

    <div class="scroll-container d-flex gap-4 overflow-auto pb-3 px-2">
        @forelse ($events as $event)
            @php
                // Determine event image path
                if ($event->banner_image) {
                    $file = \Illuminate\Support\Str::startsWith($event->banner_image, 'event-banners/')
                        ? $event->banner_image
                        : 'event-banners/' . $event->banner_image;

                    $eventImage = \Illuminate\Support\Facades\Storage::disk('public')->exists($file)
                        ? asset('storage/' . $file)
                        : asset('images/default-banner.jpg');
                } else {
                    $eventImage = asset('images/default-banner.jpg');
                }
            @endphp

            <div class="card announcement-card border-0 shadow-sm flex-shrink-0" style="width: 18rem;">
                <img src="{{ $eventImage }}" class="card-img-top" alt="{{ $event->title }}">
                <div class="card-body text-start">
                    <h5 class="fw-bold card-title mb-1">{{ $event->title }}</h5>
                    <p class="text-muted small mb-2">
                        <i class="fa-regular fa-calendar me-1"></i>
                        {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                    </p>
                    <p class="card-text small text-secondary">
                        {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 80, '...') }}
                    </p>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#eventModal{{ $event->eventID }}">
                        View Details
                    </button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="eventModal{{ $event->eventID }}" tabindex="-1" aria-labelledby="eventModalLabel{{ $event->eventID }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventModalLabel{{ $event->eventID }}">{{ $event->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ $eventImage }}" class="img-fluid mb-3" alt="{{ $event->title }}">
                            <p class="text-muted"><i class="fa-regular fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                            </p>
                            <p>{!! nl2br(e($event->description)) !!}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            @auth('alumni')
                                <form method="POST" action="{{ route('events.register', $event->eventID) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </form>
                            @else
                                <a href="{{ route('alumni.login') }}" class="btn btn-primary">Login to Register</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">No upcoming events at the moment.</p>
        @endforelse
    </div>
</section>



<!-- ---------- Contact & Address ---------- -->
    <section class="contact-section">
        <div class="container">
            <h3 class="text-center mb-5">Contact Us</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item"><i class="fa-solid fa-location-dot"></i> 
                        <strong>Address:</strong> Bulacan State University, Guinhawa, Malolos, Bulacan
                    </div>
                    <div class="info-item"><i class="fa-solid fa-phone"></i> 
                        <strong>Phone Number:</strong> (044) 919 7800
                    </div>
                    <div class="info-item"><i class="fa-solid fa-envelope"></i> 
                        <strong>E-mail Address:</strong> cictalumnimanagementsystem@gmail.com
                    </div>
                    <div class="info-item"><i class="fa-solid fa-clock"></i> 
                        <strong>Office Hours:</strong> Monday to Friday : 9:00 AM - 6:00 PM
                    </div>
                </div>

                <div class="col-md-6">
                    <p>
                        We are here to address any questions you may have about the CICT Alumni Management System.
                        Please contact us and we will get back to you as soon as possible.
                    </p>
                    <form class="contact-form">
                        <div class="mb-3">
                            <label class="form-label">Name (LN, FN, MI.)</label>
                            <input type="text" class="form-control" placeholder="Enter your full name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-mail Address</label>
                            <input type="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Year of Graduation</label>
                            <input type="text" class="form-control" placeholder="Enter year">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Course/Program</label>
                            <input type="text" class="form-control" placeholder="Enter course or program">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Compose Message</label>
                            <textarea class="form-control" rows="3" placeholder="Type your message..."></textarea>
                        </div>
                        <button class="btn btn-primary w-100">Submit</button>
                        <p class="privacy-note mt-3">
                            <strong>Privacy Notice:</strong> By submitting this form, you agree to provide your personal
                            information for the purpose of responding to your inquiry. Your data will be stored securely
                            and retained only as long as necessary.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ---------- Footer ---------- -->
    <footer class="text-center mb-0"> <!-- FIX: Removed mt-5 mb-3 -->
        <small>Bulacan State University © {{ date('Y') }} |
            <a href="{{ route('admin.login') }}" class="text-light text-decoration-none">Admin Login</a>
            <p style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin: 0;">
                <a href="https://www.facebook.com/bulsucict.alumni" target="_blank" style="color: inherit; text-decoration: none;">
                    Facebook
                </a> | 
                <a href="mailto:cictalumni@bulsu.edu.ph" style="color: inherit; text-decoration: none;">
                    cictalumni@bulsu.edu.ph
                </a> | 
                <a href="tel:+639123456789" style="color: inherit; text-decoration: none;">
                    +63 912 345 6789
                </a> | 
            </p>
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
