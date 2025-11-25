<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | CICT Alumni Management System</title>

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
            font-size: 1rem; /* keep same as landing page */
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
                
        /* Desktop */
        @media (min-width: 768px) {
            .content-offset {
                height: 116px; /* header 60px + navbar 56px */
            }
        }
        
        /* Mobile */
        @media (max-width: 767px) {
            .content-offset {
                height: 100px; /* header 48px + navbar 52px (adjust if needed) */
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

        .top-header h5, 
        .top-header h6 {
            margin: 0;
        }

        .top-header h6 {
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

        /* ---------- HEADER HAMBURGER ICON ---------- */
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
            font-size: 1rem; /* match landing page font */
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
            font-size: 1rem; /* match landing page */
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

        /* Content offset so gallery doesn't hide behind fixed header */
        .content-offset { height: 116px; }
        
        #galleryModal {
        z-index: 11000 !important;
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

<!-- ---------- GALLERY CONTENT ---------- -->
<div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">Gallery</h2>
    <h5 class="mb-5 text-center text-muted">Explore memorable moments and highlights of CICT alumni events.</h5>

    @if($galleryItems->count() > 0)
        <div class="row g-4 justify-content-center">
            @foreach($galleryItems as $item)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card shadow-sm gallery-card" 
                         data-bs-toggle="modal" 
                         data-bs-target="#galleryModal" 
                         data-title="{{ $item->title }}" 
                         data-caption="{{ $item->caption }}" 
                         data-image="{{ asset('storage/'.$item->image_path) }}">
                        <img src="{{ asset('storage/'.$item->image_path) }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="{{ $item->title }}">
                        <div class="card-body text-center">
                            <h6 class="fw-semibold mb-1">{{ $item->title }}</h6>
                            @if($item->caption)
                                <p class="text-muted small">{{ Str::limit($item->caption, 60, '...') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-muted">No gallery items available yet.</p>
    @endif
</div>

<!-- ---------- GALLERY MODAL ---------- -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="galleryModalImage" src="" alt="" class="img-fluid mb-3" style="max-height:500px;">
                <p id="galleryModalCaption" class="text-muted"></p>
            </div>
        </div>
    </div>
</div>
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

<!-- ---------- JS for HEADER HAMBURGER ---------- -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const hamburger = document.querySelector('.header-hamburger');
        const navbarContainer = document.getElementById('fixed-navbar-container');
        
        if (hamburger) {
            hamburger.addEventListener('click', function() {
                navbarContainer.classList.toggle('show');
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideNavbar = navbarContainer.contains(event.target);
            const isClickOnHamburger = hamburger && hamburger.contains(event.target);
            
            if (!isClickInsideNavbar && !isClickOnHamburger && window.innerWidth <= 767) {
                navbarContainer.classList.remove('show');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
    const galleryModal = document.getElementById('galleryModal');
    const modalTitle = document.getElementById('galleryModalLabel');
    const modalImage = document.getElementById('galleryModalImage');
    const modalCaption = document.getElementById('galleryModalCaption');

    document.querySelectorAll('.gallery-card').forEach(card => {
        card.addEventListener('click', function() {
            modalTitle.textContent = this.dataset.title;
            modalImage.src = this.dataset.image;
            modalCaption.textContent = this.dataset.caption; // use caption instead of description
        });
    });
});
</script>
</body>
</html>
