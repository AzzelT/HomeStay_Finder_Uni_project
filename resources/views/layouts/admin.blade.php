<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Dashboard') - HomestayFinder</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=2">

    {{-- Same fonts as the main website --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0e4b3c;
            --primary-dark: #08382d;
            --primary-light: #e6f4f0;
            --accent: #d4af37;

            --dark: #17251f;
            --text: #52615b;
            --muted: #7c8984;
            --background: #f6f8f7;
            --white: #ffffff;
            --border: #e4ebe8;

            --font-heading: 'Outfit', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: var(--font-body);
            font-size: 14px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-heading);
            color: var(--dark);
        }

        a {
            text-decoration: none;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: var(--primary);
            color: white;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            transition: transform .25s ease;
        }

        .admin-brand {
            height: 82px;
            padding: 0 24px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, .10);
        }

        .admin-brand a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-family: var(--font-heading);
            font-size: 21px;
            font-weight: 700;
        }

        .admin-brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--accent);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .admin-brand-text span {
            color: var(--accent);
        }

        .admin-sidebar-label {
            padding: 24px 24px 10px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .45);
        }

        .admin-nav {
            padding: 0 12px;
            margin: 0;
            list-style: none;
        }

        .admin-nav li {
            margin-bottom: 4px;
        }

        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            color: rgba(255, 255, 255, .72);
            font-size: 13px;
            font-weight: 500;
            transition: .2s ease;
        }

        .admin-nav a i {
            width: 20px;
            font-size: 17px;
            text-align: center;
        }

        .admin-nav a:hover {
            background: rgba(255, 255, 255, .09);
            color: white;
        }

        .admin-nav a.active {
            background: white;
            color: var(--primary);
            font-weight: 700;
        }

        .admin-nav a.active i {
            color: var(--accent);
        }

        .admin-sidebar-bottom {
            margin-top: auto;
            padding: 16px 12px;
            border-top: 1px solid rgba(255, 255, 255, .10);
        }

        .admin-sidebar-bottom a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: rgba(255, 255, 255, .70);
            font-size: 13px;
        }

        .admin-sidebar-bottom a:hover {
            background: rgba(255, 255, 255, .08);
            color: white;
        }

        /* =========================
           MAIN AREA
        ========================= */

        .admin-main {
            margin-left: 250px;
            min-height: 100vh;
        }

        /* =========================
           TOPBAR
        ========================= */

        .admin-topbar {
            height: 82px;
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }

        .admin-page-title {
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .admin-page-subtitle {
            color: var(--muted);
            font-size: 12px;
            margin-top: 2px;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #156d56);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 14px;
        }

        .admin-user-name {
            color: var(--dark);
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 13px;
        }

        .admin-user-role {
            color: var(--muted);
            font-size: 11px;
        }

        /* =========================
           CONTENT
        ========================= */

        .admin-content {
            padding: 32px;
        }

        .admin-page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
        }

        .admin-page-head h1 {
            margin: 0;
            font-size: 27px;
            font-weight: 700;
        }

        .admin-page-head p {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        /* =========================
           CARDS
        ========================= */

        .admin-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(14, 75, 60, .04);
        }

        .admin-card-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-card-header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .admin-card-body {
            padding: 20px;
        }

        /* =========================
           STAT CARDS
        ========================= */

        .admin-stat-card {
            position: relative;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 21px;
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .admin-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 75, 60, .08);
        }

        .admin-stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 17px;
        }

        .admin-stat-number {
            font-family: var(--font-heading);
            color: var(--dark);
            font-size: 27px;
            font-weight: 700;
            line-height: 1;
        }

        .admin-stat-label {
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
        }

        /* =========================
           BADGES
        ========================= */

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-green {
            background: var(--primary-light);
            color: var(--primary);
        }

        .badge-gold {
            background: #fbf5df;
            color: #94751b;
        }

        .badge-gray {
            background: #f0f2f1;
            color: #65716c;
        }

        /* =========================
           BUTTONS
        ========================= */

        .admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border: 0;
            border-radius: 9px;
            padding: 9px 14px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 600;
            transition: .2s ease;
        }

        .admin-btn-primary {
            background: var(--primary);
            color: white;
        }

        .admin-btn-primary:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
        }

        .admin-btn-gold {
            background: var(--accent);
            color: var(--primary);
        }

        .admin-btn-gold:hover {
            background: #c49f2d;
            color: var(--primary);
        }

        .admin-btn-light {
            background: var(--primary-light);
            color: var(--primary);
        }

        .admin-btn-light:hover {
            background: #d8eee8;
            color: var(--primary);
        }

        .admin-btn-danger {
            background: #fff0f0;
            color: #b42318;
        }

        .admin-btn-danger:hover {
            background: #ffe1e1;
            color: #a51b12;
        }

        /* =========================
           TABLE
        ========================= */

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            padding: 12px 20px;
            background: #fafcfb;
            border-bottom: 1px solid var(--border);
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            text-align: left;
        }

        .admin-table td {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            font-size: 12px;
            vertical-align: middle;
        }

        .admin-table tr:last-child td {
            border-bottom: 0;
        }

        .admin-table tr:hover td {
            background: #fcfdfd;
        }

        /* =========================
           FORMS
        ========================= */

        .admin-form-label {
            display: block;
            margin-bottom: 7px;
            color: var(--dark);
            font-size: 12px;
            font-weight: 600;
        }

        .admin-form-control {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 10px 12px;
            background: white;
            color: var(--dark);
            font-family: var(--font-body);
            font-size: 12px;
            outline: none;
            transition: .2s ease;
        }

        .admin-form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 75, 60, .08);
        }

        /* =========================
           ALERTS
        ========================= */

        .admin-alert {
            border: 0;
            border-radius: 10px;
            font-size: 13px;
        }

        /* =========================
           MOBILE
        ========================= */

        .admin-mobile-button {
            display: none;
            border: 0;
            background: var(--primary-light);
            color: var(--primary);
            width: 38px;
            height: 38px;
            border-radius: 9px;
            font-size: 19px;
        }

        .admin-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .35);
            z-index: 1040;
        }

        @media (max-width: 991px) {

            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-overlay.show {
                display: block;
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-mobile-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .admin-topbar {
                padding: 0 20px;
            }

            .admin-content {
                padding: 24px 20px;
            }
        }

        @media (max-width: 575px) {

            .admin-content {
                padding: 20px 15px;
            }

            .admin-topbar {
                height: 70px;
                padding: 0 15px;
            }

            .admin-page-title {
                font-size: 17px;
            }

            .admin-page-subtitle {
                display: none;
            }

            .admin-user-name,
            .admin-user-role {
                display: none;
            }

            .admin-page-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .admin-page-head h1 {
                font-size: 23px;
            }

            .admin-table {
                min-width: 650px;
            }

            .admin-card {
                overflow-x: auto;
            }
        }

        @stack('styles')
    </style>
</head>

<body>

    {{-- Mobile overlay --}}
    <div class="admin-overlay" id="adminOverlay"></div>

    {{-- =========================
         SIDEBAR
    ========================== --}}
    <aside class="admin-sidebar" id="adminSidebar">

        <div class="admin-brand">
            <a href="{{ route('admin.dashboard') }}">
                <span class="admin-brand-icon">
                    <i class="bi bi-house-heart-fill"></i>
                </span>

                <span class="admin-brand-text">
                    Homestay<span>Finder</span>
                </span>
            </a>
        </div>

        <div class="admin-sidebar-label">
            Management
        </div>

        <ul class="admin-nav">

            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.homestays') }}"
                    class="{{ request()->routeIs('admin.homestays*') ? 'active' : '' }}">
                    <i class="bi bi-buildings-fill"></i>
                    <span>Manage Homestays</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.reviews') }}"
                    class="{{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                    <i class="bi bi-star-fill"></i>
                    <span>Manage Reviews</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Manage Users</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.hosts') }}" class="{{ request()->routeIs('admin.hosts*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Manage Hosts</span>
                </a>
            </li>

        </ul>

        <div class="admin-sidebar-bottom">

            <a href="{{ route('home') }}">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Website</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf

                <button type="submit"
                    style="
                            width:100%;
                            border:0;
                            background:transparent;
                            text-align:left;
                            display:flex;
                            align-items:center;
                            gap:12px;
                            padding:11px 14px;
                            border-radius:10px;
                            color:rgba(255,255,255,.70);
                            font-family:var(--font-body);
                            font-size:13px;
                        ">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>

        </div>

    </aside>

    {{-- =========================
         MAIN
    ========================== --}}
    <main class="admin-main">

        {{-- Topbar --}}
        <header class="admin-topbar">

            <div class="d-flex align-items-center gap-3">

                <button class="admin-mobile-button" id="adminMenuButton">
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <h1 class="admin-page-title">
                        @yield('title', 'Admin Dashboard')
                    </h1>

                    <div class="admin-page-subtitle">
                        Manage your HomestayFinder platform
                    </div>
                </div>

            </div>

            @auth
                <div class="admin-user">

                    <div class="text-end">
                        <div class="admin-user-name">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="admin-user-role">
                            Administrator
                        </div>
                    </div>

                    <div class="admin-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                </div>
            @endauth

        </header>

        {{-- Page content --}}
        <div class="admin-content">

            @if (session('success'))
                <div class="alert alert-success admin-alert mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger admin-alert mb-4">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>

    </main>

    <script>
        const menuButton = document.getElementById('adminMenuButton');
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminOverlay');

        if (menuButton) {
            menuButton.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
    </script>

    @stack('scripts')

</body>

</html>
