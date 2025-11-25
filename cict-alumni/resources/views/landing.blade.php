<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CICT Alumni Management System</title>

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

/* Custom Hamburger Icon for Header */
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

    /* HIDE DESKTOP NAV ON MOBILE */
    .navbar-nav.d-flex {
        display: none !important;
    }

    .navbar-collapse.show .navbar-nav.d-flex {
        display: flex !important;
        flex-direction: column !important;
    }
}

/* ---------- Carousel ---------- */
.carousel-item {
    height: 70vh;
    color: white;
    background-image: url('/images/bulsu.jpg');
    background-size: cover;
    background-position: center;
    position: relative;
    width: 100vw;
    margin-left: calc(-50vw + 50%);
}

.carousel-item::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(30, 58, 138, 0.7);
}

.carousel-caption {
    margin-top: 50px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
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

/* ---------- Responsive ---------- */
@media (max-width: 991px) {
    .carousel-item { height: 50vh; }
    
    .top-header {
        padding: 10px 20px;
        min-height: 60px !important;
    }

    .content-offset {
        height: 116px !important;
    }
}

@media (max-width: 767px) {
    /* ---------- SHOW HAMBURGER IN HEADER ---------- */
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

    /* FIX: Full width for all containers */
    .container-fluid {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin: 0 !important;
        width: 100vw !important;
    }

    .container {
        padding-left: 15px !important;
        padding-right: 15px !important;
        max-width: 100% !important;
    }
}

/* ---------- Cards ---------- */
.announcement-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.announcement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

/* ---------- Featured Alumni ---------- */
.featured-alumni-section {
    margin-top: 50px;
    background-color: #f1f5f9;
    padding: 80px 0 40px;
}

.alumni-card {
    background-color: white;
    border: 1px solid #e5e7eb;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: transform 0.2s ease-in-out;
}

.alumni-card:hover {
    transform: translateY(-5px);
}

.alumni-photo {
    width: 100%;
    height: 220px;
    object-fit: cover;
}

.alumni-info {
    padding: 20px;
    text-align: center;
}

.alumni-name {
    font-weight: 600;
    font-size: 1.2rem;
    color: #1e3a8a;
}

.alumni-batch {
    font-size: 0.9rem;
    color: #6b7280;
}

.alumni-achievement {
    font-size: 0.95rem;
    color: #374151;
    margin-top: 10px;
}

.scroll-container::-webkit-scrollbar {
    height: 8px;
}
.scroll-container::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 10px;
}
.scroll-container {
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,0.2) transparent;
}
.announcement-card img {
    height: 180px;
    object-fit: cover;
}

.scroll-container {
    display: flex;
    overflow-x: auto;
    gap: 1rem;
    padding-bottom: 10px;
}

.scroll-container::-webkit-scrollbar {
    height: 8px;
}
.scroll-container::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 10px;
}

.announcement-card {
    display: block;
    min-width: 18rem;
}

/* Ensure modal is above fixed header/navbar */
.modal {
    z-index: 11000 !important; /* higher than your navbar (10000/10001) */
}

/* Optional: backdrop should stay below modal */
.modal-backdrop {
    z-index: 10999 !important;
}

.alumni-card {
    transition: transform 0.3s;
}

.alumni-card:hover {
    transform: translateY(-5px);
}

.alumni-photo {
    display: block;
}

.alumni-info {
    min-height: 100px;
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
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
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

<!-- ---------- Carousel ---------- -->
<div id="homeCarousel" class="carousel slide" data-bs-ride="false">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="carousel-caption">
                <h1>CICT Alumni Management System</h1>
                <p>Connecting graduates, fostering opportunities, and celebrating success.</p>
            </div>
        </div>
        <div class="carousel-item">
            <div class="carousel-caption">
                <h1>Register & Update Your Alumni Profile</h1>
                <p>Join the growing network of CICT alumni and stay connected with your peers.</p>
            </div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- ---------- Announcements ---------- -->
<section class="announcements container my-5 announcement-section">
    <h2 class="fw-bold mb-4 text-center">Announcements</h2>
    <h5 class="fw mb-4 text-center">
        Never miss the latest news! Check out our latest updates and announcements.
    </h5>

    <div class="scroll-container d-flex gap-4 overflow-auto pb-3 px-2">
        @forelse ($announcements as $announcement)
            <div class="card announcement-card border-0 shadow-sm flex-shrink-0" style="width: 18rem;">
                <img src="{{ $announcement->image_path ? asset('storage/'.$announcement->image_path) : asset('images/sample-announcement.jpg') }}"
                     class="card-img-top" alt="Announcement Image">

                <div class="card-body text-start">
                    <h5 class="fw-bold card-title mb-1">{{ $announcement->title }}</h5>
                    <p class="text-muted small mb-2">
                        <i class="fa-regular fa-calendar me-1"></i>
                        {{ \Carbon\Carbon::parse($announcement->created_at)->format('F d, Y') }}
                    </p>
                    <p class="card-text small text-secondary">
                        {{ Str::limit(strip_tags($announcement->description), 80, '...') }}
                    </p>
                    <button 
                        class="btn btn-link text-primary small fw-semibold p-0 read-more-btn" 
                        data-bs-toggle="modal" 
                        data-bs-target="#announcementModal"
                        data-title="{{ $announcement->title }}"
                        data-image="{{ $announcement->image_path ? asset('storage/'.$announcement->image_path) : asset('images/sample-announcement.jpg') }}"
                        data-content="{{ htmlspecialchars($announcement->description) }}"
                        data-date="{{ \Carbon\Carbon::parse($announcement->created_at)->format('F d, Y') }}">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">No announcements available at the moment.</p>
        @endforelse
    </div>
</section>

<!-- ---------- Modal ---------- -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="announcementModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="max-height: 70vh; overflow-y: auto;">
                <img id="announcementImage" src="" class="img-fluid rounded mb-3" 
                     alt="Announcement Image" style="max-height: 300px; width: auto; object-fit: contain;">
                <p class="text-muted small mb-3">
                    <i class="fa-regular fa-calendar me-1"></i> <span id="announcementDate"></span>
                </p>
                <div id="announcementContent" class="text-start"></div>
            </div>
        </div>
    </div>
</div>




<!-- ---------- Featured Alumni ---------- -->
<section class="featured-alumni-section py-5 bg-white">
    <div class="container">
        <h2 class="fw-bold mb-4 text-center">Featured Alumni</h2>
        <h5 class="fw mb-4 text-center">Meet some of our outstanding CICT graduates.</h5>
        <div class="row g-4 justify-content-center">
            @forelse($featuredAlumni as $alumni)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="alumni-card shadow-sm rounded overflow-hidden">
                        <img src="{{ asset('storage/'.$alumni->image_path) }}" 
                             alt="{{ $alumni->name }}" 
                             class="alumni-photo img-fluid w-100" 
                             style="height: 250px; object-fit: cover;">
                        <div class="alumni-info p-3 text-center">
                            <div class="alumni-name fw-bold">{{ $alumni->name }}</div>
                            <div class="alumni-achievement text-muted">{{ $alumni->description }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No featured alumni yet.</p>
            @endforelse
        </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        const modalTitle = document.getElementById('announcementModalLabel');
        const modalImage = document.getElementById('announcementImage');
        const modalDate = document.getElementById('announcementDate');
        const modalContent = document.getElementById('announcementContent');
    
        document.querySelectorAll('.read-more-btn').forEach(button => {
            button.addEventListener('click', function () {
                modalTitle.textContent = this.dataset.title;
                modalImage.src = this.dataset.image;
                modalDate.textContent = this.dataset.date;
                modalContent.innerHTML = this.dataset.content;
            });
        });
    });
    </script>
</body>
</html>
