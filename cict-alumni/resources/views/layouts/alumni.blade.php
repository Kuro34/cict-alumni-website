<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CICT Alumni Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Blade pushed styles -->
    @stack('styles')

    <script>
        const CURRENT_USER_ID = @json(auth('alumni')->user()->alumniID ?? null);
        const CURRENT_USER_TYPE = 'alumni';
    </script>

    <style>
        /* ---------- Base ---------- */
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-y: auto;
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
            margin-left: 10px;
        }

        .top-header .right a:hover {
            color: #93c5fd;
        }

        /* ---------- Header Hamburger Icon ---------- */
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

        /* ---------- Fixed Navbar ---------- */
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
            padding: 10px 15px;
        }

        .navbar-nav .nav-link:hover {
            color: #dbeafe !important;
        }

        .dropdown-menu {
            background-color: #3b82f6;
            border: none;
            border-radius: 8px;
        }

        .dropdown-menu a {
            color: white !important;
            padding: 10px 15px;
        }

        .dropdown-menu a:hover {
            background-color: #2563eb;
        }

        /* ---------- Profile Page Spacing ---------- */
        .page-body.no-banner .content-wrapper {
            margin-top: 0 !important;
            padding-top: 20px;
        }

        /* ---------- Profile Image ---------- */
        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #eee;
        }

        /* ---------- Content Wrapper ---------- */
        .content-wrapper {
            flex-grow: 1;
            padding: 116px 20px 20px; /* Top padding for header + navbar (desktop) */
            box-sizing: border-box;
            width: 100%;
        }

        /* Override for home page (carousel directly below navbar) */
        .home-container .content-wrapper {
            padding-top: 0 !important;
        }

        /* Full-width carousel */
        .home-container .carousel {
            width: 100vw;
            margin-left: calc(-1 * var(--bs-gutter-x) / 2);
            margin-right: calc(-1 * var(--bs-gutter-x) / 2);
        }

        .home-container .carousel img {
            width: 100%;
            object-fit: cover;
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

        /* ---------- Cards ---------- */
        .announcement-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }

        .article-card {
            transition: transform 0.3s ease;
        }

        .article-card:hover {
            transform: translateY(-3px);
        }

        .story-link {
            display: block;
            padding: 8px 0;
            color: #374151;
            text-decoration: none;
            transition: color 0.3s;
        }

        .story-link:hover,
        .story-link.active {
            color: #3b82f6 !important;
            font-weight: 600;
        }

        .info-item {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact-form .form-control {
            border-radius: 8px;
        }

        .privacy-note {
            font-size: 0.8rem;
            color: #6b7280;
        }

        /* ---------- Job Card Styles ---------- */
        .job-card {
            border: none;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            background-color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }

        .job-card-body {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .job-card-info h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e3a8a;
        }

        .job-card-info p {
            margin: 2px 0;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .job-card-actions {
            display: flex;
            gap: 8px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .job-card-actions .btn {
            font-size: 0.9rem;
            border-radius: 8px;
        }

        .job-details {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #ddd;
            margin-bottom: 16px;
        }

        .job-details h2 {
            margin-top: 0;
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e3a8a;
        }

        .job-details p {
            color: #6b7280;
            font-size: 1rem;
            margin: 4px 0;
        }

        .job-details .job-meta {
            margin-top: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.95rem;
            color: #6b7280;
        }

        /* ---------- Alumni Directory Styles ---------- */
        .directory-container {
            padding: 20px;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-form input {
            padding: 8px;
            width: 250px;
            margin-right: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .search-form button {
            padding: 8px 15px;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .search-form button:hover {
            background-color: #2563eb;
        }

        .alumni-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
        }

        .alumni-card {
            position: relative;
            width: 100%;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .alumni-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .alumni-actions {
            position: absolute;
            top: 50%;
            right: 50px;
            transform: translateY(-50%);
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .alumni-actions button,
        .alumni-actions a {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .alumni-actions button:hover,
        .alumni-actions a:hover {
            background-color: #2563eb;
        }

        /* ---------- Reward Card Styles ---------- */
        .reward-card {
            width: 100%;
            max-width: 300px;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .reward-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        /* ---------- FAB Styles ---------- */
        .fab-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column-reverse;
            align-items: flex-end;
            z-index: 1000;
        }

        .fab-container .main-fab {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #3b82f6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
            z-index: 101;
        }

        .fab-container .main-fab:hover {
            transform: scale(1.05);
        }

        .fab-container .fab-options {
            display: none;
            flex-direction: column;
            margin-bottom: 10px;
            gap: 10px;
            pointer-events: auto;
            z-index: 102;
        }

        .fab-container.active .fab-options {
            display: flex;
        }

        .fab-container .fab {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #2563eb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .fab-container .fab:hover {
            transform: scale(1.05);
        }

        /* ---------- Chat Popup Styles ---------- */
        .chat-popup {
            display: none;
            flex-direction: column;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            max-width: 90vw;
            max-height: 80vh;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            z-index: 1001;
            cursor: move;
        }

        .chat-header {
            background-color: #3b82f6;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px 8px 0 0;
            font-weight: 600;
        }

        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background-color: #f9f9f9;
        }

        .chat-list-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 8px;
            background-color: #fff;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .chat-list-item:hover {
            background-color: #f5f5f5;
        }

        #newChatPopup {
            width: 400px !important;
        }

        .message-sent,
        .message-received {
            max-width: 75%;
            padding: 10px;
            border-radius: 10px;
            position: relative;
            word-wrap: break-word;
        }

        .message-sent {
            background-color: #dcf8c6;
            margin-left: auto;
            text-align: right;
            border-bottom-right-radius: 0;
        }

        .message-received {
            background-color: #f1f0f0;
            margin-right: auto;
            text-align: left;
            border-bottom-left-radius: 0;
        }

        .message-sent small,
        .message-received small {
            display: block;
            font-size: 0.7rem;
            color: #777;
            margin-top: 5px;
        }

        .chat-footer {
            border-top: 1px solid #ddd;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #fff;
            flex-shrink: 0;
        }

        .chat-footer button {
            flex-shrink: 0;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
        }

        #emoji-btn {
            font-size: 1.2rem;
            width: 32px;
            height: 32px;
            line-height: 1;
        }

        .chat-footer input[type="text"] {
            flex: 1;
            padding: 8px 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            min-width: 0;
        }

        .chat-footer button:last-child {
            background-color: #3b82f6;
            color: white;
            padding: 8px 12px;
            font-size: 0.95rem;
            border-radius: 8px;
            border: none;
            transition: background-color 0.3s;
        }

        .chat-footer button:last-child:hover {
            background-color: #2563eb;
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
        }

        footer a {
            color: #dbeafe;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #93c5fd;
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

            .navbar-nav.d-flex {
                display: none !important;
            }

            .navbar-collapse.show .navbar-nav.d-flex {
                display: flex !important;
                flex-direction: column !important;
            }

            .top-header {
                padding: 8px 15px !important;
                min-height: 48px !important;
            }

            .top-header img {
                height: 40px;
                width: 40px;
            }

            .header-hamburger {
                display: block !important;
            }

            .top-header h5,
            .top-header h6,
            .top-header .right {
                display: none !important;
            }

            .content-wrapper {
                padding-top: 104px !important; /* Mobile top padding for header + navbar */
            }

            .home-container .content-wrapper {
                padding-top: 0 !important;
            }

            .announcement-section,
            .contact-section,
            .news-section {
                padding: 40px 0 20px;
            }

            .container {
                padding-left: 15px !important;
                padding-right: 15px !important;
                max-width: 100% !important;
            }

            .chat-popup {
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                width: 90% !important;
                max-height: 80vh !important;
                cursor: default !important;
            }

            .chat-popup .chat-body {
                max-height: calc(100% - 100px);
                overflow-y: auto;
            }

            .search-form input {
                width: 100%;
                margin-bottom: 10px;
            }

            .search-form button {
                width: 100%;
            }

            .alumni-actions {
                right: 15px;
            }

            .reward-card {
                max-width: 100%;
            }

            .chat-footer {
                flex-wrap: nowrap;
            }

            #emoji-btn {
                font-size: 1rem;
                width: 28px;
                height: 28px;
            }

            .chat-footer button:last-child {
                padding: 6px 10px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Fixed Header -->
    <header class="top-header">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <img src="/images/logo1.png" alt="Logo 1" class="logo-img">
                <img src="/images/logo2.png" alt="Logo 2" class="logo-img">
                <div class="header-text d-none d-md-block">
                    <h6 class="mb-0">College of Information and Communications Technology</h6>
                    <h6 class="mb-0">Bulacan State University</h6>
                    <h6 class="mb-0">CICT Alumni Management System</h6>
                </div>
            </div>
            <div class="right d-none d-md-flex">
                <a href="{{ route('profile.view') }}"><i class="fa-solid fa-user me-1"></i> Profile</a>
                <a href="{{ route('alumni.logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('alumni.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            <button class="header-hamburger d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="header-hamburger-icon"></span>
            </button>
        </div>
    </header>

    <!-- Fixed Navbar -->
    <div id="fixed-navbar-container">
        <nav class="navbar navbar-expand-lg navbar-dark" id="mobileNav">
            <div class="container-fluid">
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav w-100 d-flex justify-content-around text-center">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('alumni.home') ? 'active' : '' }}" href="{{ route('alumni.home') }}">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('jobs.*') ? 'active' : '' }}" href="#" id="careersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Careers
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="careersDropdown">
                                <li><a class="dropdown-item" href="{{ route('jobs.index') }}">Job Openings</a></li>
                                <li><a class="dropdown-item" href="{{ route('jobs.bookmarked') }}">Bookmarked Jobs</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('events.*') ? 'active' : '' }}" href="#" id="eventsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Events
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="eventsDropdown">
                                <li><a class="dropdown-item" href="{{ route('events.index') }}">Upcoming Events</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('rewards.*') ? 'active' : '' }}" href="{{ route('rewards.index') }}">Raffles & Rewards</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('directory.*') ? 'active' : '' }}" href="{{ route('directory.index') }}">Alumni Directory</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('alumni.surveys.*') ? 'active' : '' }}" href="{{ route('alumni.surveys.index') }}">Feedback & Surveys</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('alumni.about') ? 'active' : '' }}" href="{{ route('alumni.about') }}">About</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('profile.view') }}"><i class="fa-solid fa-user me-1"></i> Profile</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('alumni.logout') }}" 
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Page Content -->
    <div class="page-body" style="flex-grow: 1; display: flex; flex-direction: column; width: 100%;">
        <div class="content-wrapper container-fluid">@yield("content")</div>
    </div>

    <!-- Footer -->
    <footer class="text-center mb-0">
        <small>
            Bulacan State University © {{ date('Y') }} |
            <a href="{{ route('admin.login') }}" class="text-light text-decoration-none">Admin Login</a>
            <p style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin: 0;">
                <a href="https://www.facebook.com/bulsucict.alumni" target="_blank">Facebook</a> |
                <a href="mailto:cictalumni@bulsu.edu.ph">cictalumni@bulsu.edu.ph</a> |
                <a href="tel:+639123456789">+63 912 345 6789</a>
            </p>
        </small>
    </footer>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/messenger.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FAB / Chat / Emoji / Bookmark Setup -->
    <script>
        function toggleFAB(event) {
            event.stopPropagation();
            const container = document.querySelector(".fab-container");
            container.classList.toggle("active");
            container.querySelector(".main-fab").style.pointerEvents = container.classList.contains("active") ? "none" : "auto";
        }

        function openChatList(event) {
            event.stopPropagation();
            document.getElementById("chatPopup").style.display = "flex";
            document.getElementById("conversationPopup").style.display = "none";
            document.getElementById("newChatPopup").style.display = "none";
            if (typeof loadChatList === 'function') loadChatList('');
        }

        function openNewChat(event) {
            event.stopPropagation();
            document.getElementById("fab-options").style.pointerEvents = "none";
            document.getElementById("chatPopup").style.display = "none";
            document.getElementById("conversationPopup").style.display = "none";
            document.getElementById("newChatPopup").style.display = "flex";
            document.getElementById("newChatSearchInput").value = "";
            document.getElementById("newChatResults").innerHTML = "<p>Type to search users...</p>";
            document.getElementById("newChatSearchInput").focus();
            document.getElementById("fab-options").style.pointerEvents = "auto";
        }

        function closeNewChat() {
            document.getElementById("newChatPopup").style.display = "none";
            document.getElementById("chatPopup").style.display = "flex";
        }

        function closeChat() {
            document.getElementById("chatPopup").style.display = "none";
            const searchInput = document.getElementById("chatSearchInput");
            if (searchInput) searchInput.value = "";
            if (typeof loadChatList === 'function') loadChatList('');
        }

        function closeConversation() {
            document.getElementById("conversationPopup").style.display = "none";
            document.getElementById("chatPopup").style.display = "flex";
            if (typeof loadChatList === 'function') loadChatList('');
        }

        function makeDraggable(element) {
            let posX = 0, posY = 0, mouseX = 0, mouseY = 0;
            const header = element.querySelector(".chat-header");
            if (header) {
                header.onmousedown = dragMouseDown;
            }

            function dragMouseDown(e) {
                if (e.target.tagName !== "INPUT" && e.target.tagName !== "BUTTON") {
                    e.preventDefault();
                    mouseX = e.clientX;
                    mouseY = e.clientY;
                    document.onmouseup = closeDragElement;
                    document.onmousemove = elementDrag;
                }
            }

            function elementDrag(e) {
                e.preventDefault();
                posX = mouseX - e.clientX;
                posY = mouseY - e.clientY;
                mouseX = e.clientX;
                mouseY = e.clientY;
                element.style.top = (element.offsetTop - posY) + "px";
                element.style.left = (element.offsetLeft - posX) + "px";
            }

            function closeDragElement() {
                document.onmouseup = null;
                document.onmousemove = null;
            }

            if ('ontouchstart' in window) return;
        }

        function setupChatSearch() {
            const searchInput = document.getElementById("chatSearchInput");
            if (!searchInput) return;

            let searchTimeout;
            searchInput.addEventListener("input", function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const query = e.target.value.trim();
                    if (typeof loadChatList === 'function') loadChatList(query);
                }, 300);
            });
            searchInput.addEventListener("click", function(e) {
                e.stopPropagation();
                this.focus();
            });
        }

        function setupBookmarkButtons() {
            document.querySelectorAll('.bookmark-btn').forEach(btn => {
                btn.onclick = function() {
                    const jobID = this.dataset.job;
                    const icon = this.querySelector('i');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                    axios.post(`/jobs/${jobID}/bookmark`, {}, {
                        headers: {'X-CSRF-TOKEN': csrfToken}
                    }).then(res => {
                        if (res.data.status === 'added') {
                            icon.classList.remove('bi-bookmark');
                            icon.classList.add('bi-bookmark-fill', 'text-primary');
                            const bookmarkedList = document.getElementById('bookmarkedJobsList');
                            if (bookmarkedList) {
                                if (document.getElementById('no-bookmarked')) {
                                    document.getElementById('no-bookmarked').remove();
                                }
                                const job = res.data.job;
                                const div = document.createElement('div');
                                div.classList.add('job-card');
                                div.id = `bookmarked-job-card-${job.jobID}`;
                                div.innerHTML = `
                                    <div class="job-card-body">
                                        <div class="job-card-info">
                                            <h3>${job.title}</h3>
                                            <p><i class="bi bi-building"></i> ${job.company || '-'}</p>
                                            <p><i class="bi bi-geo-alt"></i> ${job.location || '-'}</p>
                                            <p><i class="bi bi-person"></i> ${job.admin_name}</p>
                                        </div>
                                        <div class="job-card-actions">
                                            <a href="/jobs/${job.jobID}" class="btn btn-primary view-btn">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                            <button class="btn btn-outline-secondary btn-sm bookmark-btn" data-job="${job.jobID}">
                                                <i class="bi bi-bookmark-fill text-primary"></i>
                                            </button>
                                        </div>
                                    </div>
                                `;
                                bookmarkedList.appendChild(div);
                                setupBookmarkButtons();
                            }
                        } else {
                            icon.classList.remove('bi-bookmark-fill', 'text-primary');
                            icon.classList.add('bi-bookmark');
                            const card = document.getElementById(`bookmarked-job-card-${jobID}`);
                            if (card) card.remove();
                            const bookmarkedList = document.getElementById('bookmarkedJobsList');
                            if (bookmarkedList && bookmarkedList.children.length === 0) {
                                bookmarkedList.innerHTML = '<p id="no-bookmarked">You have no bookmarked jobs.</p>';
                            }
                        }
                    }).catch(err => {
                        console.error('Bookmark toggle failed:', err);
                    });
                };
            });
        }

        window.onload = () => {
            const chatPopup = document.getElementById("chatPopup");
            const conversationPopup = document.getElementById("conversationPopup");
            const newChatPopup = document.getElementById("newChatPopup");

            if (chatPopup) makeDraggable(chatPopup);
            if (conversationPopup) makeDraggable(conversationPopup);
            if (newChatPopup) makeDraggable(newChatPopup);

            setupChatSearch();
            setupBookmarkButtons();

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
        };

        document.addEventListener("click", () => {
            const container = document.querySelector(".fab-container");
            if (container) {
                container.classList.remove("active");
                const mainFab = container.querySelector(".main-fab");
                if (mainFab) mainFab.style.pointerEvents = "auto";
            }
        });

        ["chatPopup", "conversationPopup", "newChatPopup", "fab-options"].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener("click", e => e.stopPropagation());
            }
        });

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            if (message && typeof sendMessageToServer === 'function') {
                sendMessageToServer(message);
                input.value = '';
            }
        }
    </script>

    <!-- Emoji Picker -->
    <script type="module">
        import { EmojiButton } from 'https://cdn.skypack.dev/@joeattardi/emoji-button';
        const button = document.getElementById('emoji-btn');
        const input = document.getElementById('messageInput');
        if (button && input) {
            const picker = new EmojiButton({
                position: 'top-end',
                theme: 'light',
                autoHide: false
            });
            button.addEventListener('click', () => {
                picker.togglePicker(button);
            });
            picker.on('emoji', selection => {
                if (selection && selection.emoji) {
                    input.value += selection.emoji;
                    input.focus();
                }
            });
        }
    </script>
</body>
</html>