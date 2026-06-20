<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} | Admin Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary-blue: #0d47a1;
            --light-blue: #1565c0;
            --accent-green: #2e7d32;
            --light-green: #43a047;
            --soft-white: #f4f7fa;
            --sidebar-width: 260px;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--soft-white);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-blue) 0%, #0a3577 100%);
            position: fixed;
            top: 0;
            left: 0;
            transition: margin-left 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-brand {
            padding: 22px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand h4 {
            color: #fff;
            font-weight: 700;
            font-size: 1.15rem;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .sidebar-brand i {
            color: var(--light-green);
            font-size: 1.6rem;
            display: block;
            margin-bottom: 6px;
        }

        .sidebar-menu {
            padding: 15px 0;
        }

        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 22px;
            font-size: 0.93rem;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.25s ease;
        }

        .sidebar-menu .nav-link i {
            font-size: 1.1rem;
            width: 20px;
        }

        .sidebar-menu .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            border-left-color: var(--light-green);
        }

        .sidebar-menu .nav-link.active {
            background: rgba(67, 160, 71, 0.2);
            color: #fff;
            border-left-color: var(--accent-green);
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-footer button {
            color: rgba(255,255,255,0.85);
            width: 100%;
            text-align: left;
            padding: 14px 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.93rem;
            border: none;
            background: none;
        }

        .sidebar-footer button:hover {
            background: rgba(220, 53, 69, 0.15);
            color: #fff;
        }

        /* ===== MAIN CONTENT ===== */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper.full {
            margin-left: 0;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 12px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar .toggle-btn {
            background: var(--soft-white);
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            color: var(--primary-blue);
            font-size: 1.1rem;
        }

        .topbar .toggle-btn:hover {
            background: #e3eaf3;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--soft-white);
            padding: 6px 14px 6px 6px;
            border-radius: 50px;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--light-blue), var(--accent-green));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .badge-online {
            width: 9px;
            height: 9px;
            background: var(--accent-green);
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 25px;
            flex: 1;
        }

        .page-header {
            margin-bottom: 20px;
        }

        .page-header h2 {
            color: var(--primary-blue);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .page-header p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        footer.app-footer {
            text-align: center;
            padding: 15px;
            font-size: 0.85rem;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
            background: #fff;
        }

        @media (max-width: 768px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .sidebar.show { margin-left: 0; }
            .main-wrapper { margin-left: 0; }
        }
    </style>

    @yield('styles')
</head>
<body>

<div class="d-flex">

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <i class="bi bi-globe-americas"></i>
            <h4>Landslide System</h4>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-activity"></i> Live Sensor Data
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-exclamation-triangle"></i> Alerts
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-bar-chart-line"></i> Reports
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-people"></i> Users Management
            </a>

            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> My Profile
            </a>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

    </div>

    <!-- ===== MAIN WRAPPER ===== -->
    <div class="main-wrapper" id="mainWrapper">

        <!-- TOPBAR -->
        <nav class="topbar">
            <button class="toggle-btn" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>

            <div class="user-chip">
                <span class="badge-online"></span>
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
            </div>
        </nav>

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <div class="page-header">
                <h2>@yield('page-title', 'Dashboard Overview')</h2>
                <p>@yield('page-subtitle', 'Monitor landslide detection sensors in real-time')</p>
            </div>

            @yield('content')

        </div>

        <footer class="app-footer">
            &copy; {{ date('Y') }} Landslide Detection System — All rights reserved.
        </footer>

    </div>

</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainWrapper = document.getElementById('mainWrapper');

    toggleBtn.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');
            mainWrapper.classList.toggle('full');
        }
    });
</script>

@yield('scripts')

</body>
</html>