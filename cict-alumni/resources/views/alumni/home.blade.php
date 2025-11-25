@extends('layouts.alumni')

@section('content')
<style>
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

    .announcement-section,
    .contact-section,
    .daily-tasks-section {
        background-color: #f1f5f9;
        padding: 80px 0 40px;
        margin-bottom: 0 !important;
        width: 100%;
    }

    .announcement-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .announcement-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }

    .task-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: white;
        border-radius: 12px;
        padding: 20px;
    }

    .task-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }

    .task-status {
        font-size: 0.85rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .task-status.completed { background-color: #d1fae5; color: #065f46; }
    .task-status.pending { background-color: #fee2e2; color: #991b1b; }

    @media (max-width: 991px) {
        .carousel-item { height: 50vh; }
    }

    @media (max-width: 767px) {
        .announcement-section,
        .contact-section,
        .daily-tasks-section {
            padding: 40px 0 20px;
        }

        .container {
            padding-left: 15px !important;
            padding-right: 15px !important;
            max-width: 100% !important;
        }
    }
    .modal { z-index: 11000 !important; }
    .modal-backdrop { z-index: 10999 !important; }
</style>

<div class="home-container">
    <!-- Carousel -->
    <div id="homeCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="carousel-caption">
                    <h1>CICT Alumni Management System</h1>
                    <p>Welcome back, {{ auth('alumni')->user()->first_name }}! Stay connected with our community.</p>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-caption">
                    <h1>Your Alumni Hub</h1>
                    <p>Explore events, jobs, and rewards tailored for you.</p>
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
    


    <!-- Daily Tasks -->
    <section class="daily-tasks-section">
        <div class="container">
            <h3 class="fw-bold mb-4 text-center">Daily Tasks</h3>
            <h5 class="fw mb-4 text-center">Complete your daily tasks to earn rewards and boost your alumni points!</h5>

            <div class="row g-4 justify-content-center">
                @foreach ([
                    ['Task Title' => 'Participate in a Survey', 'Description' => 'Answer the latest alumni feedback survey.', 'Status' => 'pending'],
                    ['Task Title' => 'Register for an Event', 'Description' => 'Sign up for this week’s CICT alumni seminar.', 'Status' => 'completed'],
                    ['Task Title' => 'Update Your Profile', 'Description' => 'Ensure your alumni profile details are up-to-date.', 'Status' => 'pending'],
                    ['Task Title' => 'Refer a Friend', 'Description' => 'Invite a fellow alumnus to join the system.', 'Status' => 'completed']
                ] as $task)
                    <div class="col-md-3 col-sm-6">
                        <div class="task-card shadow-sm h-100">
                            <h5 class="fw-bold mb-1">{{ $task['Task Title'] }}</h5>
                            <p class="text-secondary small mb-2">{{ $task['Description'] }}</p>
                            <span class="task-status {{ $task['Status'] }}">
                                {{ ucfirst($task['Status']) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact & Address -->
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
                            <input type="text" class="form-control" value="{{ auth('alumni')->user()->first_name }} {{ auth('alumni')->user()->last_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-mail Address</label>
                            <input type="email" class="form-control" value="{{ auth('alumni')->user()->email }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Year of Graduation</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Course/Program</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Compose Message</label>
                            <textarea class="form-control" rows="3"></textarea>
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
</div>
@endsection
