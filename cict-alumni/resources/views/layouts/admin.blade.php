<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CICT Admin Dashboard</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1e3a8a;
            color: white;
            padding-top: 1rem;
            overflow-y: hidden;
            transition: all 0.3s ease;
        }
        .sidebar:hover {
            overflow-y: auto;
        }
        .sidebar h2 {
            font-size: 1.4rem;
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #3b82f6;
            color: #fff;
        }

        /* Submenu styling */
        .sidebar .collapse a {
            padding-left: 35px;
            font-size: 0.9rem;
            border-radius: 6px;
        }
        .sidebar .collapse a:hover, .sidebar .collapse a.active {
            background-color: #2563eb;
            color: #fff;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .topbar {
            background-color: white;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .topbar .admin-info {
            float: right;
        }
        .topbar .admin-info span {
            font-weight: 500;
            color: #1e3a8a;
        }
        .logout-button {
            cursor: pointer;
            display: block;
            color: white;
            padding: 12px 20px;
            font-size: 0.95rem;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }
        .logout-button:hover {
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>

        {{-- Alumni Dropdown --}}
        <a href="#alumniSubmenu"
           data-bs-toggle="collapse"
           aria-expanded="{{ request()->routeIs('admin.alumni.*') || request()->routeIs('admin.masterlist.*') || request()->routeIs('admin.featured-alumni.*') || request()->routeIs('admin.gallery.*') ? 'true' : 'false' }}"
           class="dropdown-toggle {{ request()->routeIs('admin.alumni.*') || request()->routeIs('admin.masterlist.*') || request()->routeIs('admin.featured-alumni.*') || request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
           🎓 Alumni
        </a>
        <div class="collapse {{ request()->routeIs('admin.alumni.*') || request()->routeIs('admin.masterlist.*') || request()->routeIs('admin.featured-alumni.*') || request()->routeIs('admin.gallery.*') ? 'show' : '' }}" id="alumniSubmenu">
            <a href="{{ route('admin.alumni.index') }}"
               class="{{ request()->routeIs('admin.alumni.index') ? 'active' : '' }}">
               • Registered Alumni
            </a>
            <a href="{{ route('admin.masterlist.index') }}"
               class="{{ request()->routeIs('admin.masterlist.*') ? 'active' : '' }}">
               • Alumni Masterlist
            </a>
            <a href="{{ route('admin.featured-alumni.index') }}"
               class="{{ request()->routeIs('admin.featured-alumni.*') ? 'active' : '' }}">
               • Featured Alumni
            </a>
            <a href="{{ route('admin.gallery.index') }}"
               class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
               • Gallery
            </a>
        </div>

        <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">📅 Events</a>
        <a href="{{ route('admin.jobs.index') }}" class="{{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">💼 Job Postings</a>
        <a href="{{ route('admin.surveys.index') }}" class="{{ request()->routeIs('admin.surveys.*') ? 'active' : '' }}">📝 Surveys</a>
        <a href="{{ route('admin.rewards.index') }}" class="{{ request()->routeIs('admin.rewards.*') ? 'active' : '' }}">🎁 Rewards</a>
        <a href="{{ route('admin.raffles.index') }}" class="{{ request()->routeIs('admin.raffles.*') ? 'active' : '' }}">🎟 Raffles</a>

        {{-- Announcements --}}
        <a href="{{ route('admin.announcements.index') }}" class="{{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
            📢 Announcements
        </a>

        {{-- Reports Dropdown --}}
        <a href="#reportsSubmenu"
           data-bs-toggle="collapse"
           aria-expanded="{{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }}"
           class="dropdown-toggle {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
           📊 Reports
        </a>
        <div class="collapse {{ request()->routeIs('admin.reports.*') ? 'show' : '' }}" id="reportsSubmenu">
            <a href="{{ route('admin.reports.alumniParticipation') }}" 
               class="{{ request()->routeIs('admin.reports.alumniParticipation') ? 'active' : '' }} ms-3 d-block">
               • Alumni Participation
            </a>
            <a href="{{ route('admin.reports.pointsRedemptions') }}" 
               class="{{ request()->routeIs('admin.reports.pointsRedemptions') ? 'active' : '' }} ms-3 d-block">
               • Points & Redemptions
            </a>
            <a href="{{ route('admin.reports.events') }}" 
               class="{{ request()->routeIs('admin.reports.events') ? 'active' : '' }} ms-3 d-block">
               • Events Report
            </a>
            <a href="{{ route('admin.reports.surveys') }}" 
               class="{{ request()->routeIs('admin.reports.surveys') ? 'active' : '' }} ms-3 d-block">
               • Surveys Report
            </a>
            <a href="{{ route('admin.reports.jobs') }}" 
               class="{{ request()->routeIs('admin.reports.jobs') ? 'active' : '' }} ms-3 d-block">
               • Job Postings Report
            </a>
        </div>

        <a href="{{ route('admin.admins.index') }}" class="{{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">🛡️ Manage Admins</a>

        {{-- Logout --}}
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a class="logout-button" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            🔒 Logout
        </a>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="admin-info">
                <span>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
            </div>
            <div style="clear: both;"></div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
