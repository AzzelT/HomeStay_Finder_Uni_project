<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Homestay Finder</title>
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <link href="{{ asset('backend/assets/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet">
    <style>
        :root { --admin-blue:#4f46e5; --admin-dark:#172033; --admin-bg:#f6f8fc; }
        body { background:var(--admin-bg); }
        .admin-shell { min-height:100vh; }
        .admin-sidebar { position:fixed; inset:0 auto 0 0; width:250px; background:var(--admin-dark); color:#fff; z-index:1040; padding:18px 14px; }
        .admin-brand { height:48px; display:flex; align-items:center; padding:0 12px 16px; margin-bottom:10px; border-bottom:1px solid rgba(255,255,255,.08); }
        .admin-brand img { max-height:32px; max-width:145px; object-fit:contain; }
        .admin-section { color:#94a3b8; font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; padding:18px 12px 7px; }
        .admin-nav { list-style:none; padding:0; margin:0; }
        .admin-nav a { display:flex; align-items:center; gap:12px; color:#cbd5e1; text-decoration:none; padding:11px 12px; margin:3px 0; border-radius:9px; font-size:14px; }
        .admin-nav a:hover { background:rgba(255,255,255,.07); color:#fff; }
        .admin-nav .active a { background:var(--admin-blue); color:#fff; }
        .admin-nav i { width:20px; text-align:center; font-size:18px; }
        .admin-main { margin-left:250px; min-height:100vh; }
        .admin-topbar { height:68px; background:#fff; border-bottom:1px solid #e7ebf2; display:flex; align-items:center; justify-content:space-between; padding:0 28px; position:sticky; top:0; z-index:1000; }
        .admin-topbar-title { font-weight:700; color:#172033; }
        .admin-content { padding:28px; }
        .admin-page-head { display:flex; align-items:flex-end; justify-content:space-between; gap:20px; margin-bottom:24px; }
        .admin-page-head h1 { font-size:25px; margin:0 0 5px; color:#172033; font-weight:700; }
        .admin-page-head p { margin:0; color:#7b8799; }
        .admin-card { background:#fff; border:1px solid #e8ecf3; border-radius:14px; box-shadow:0 4px 18px rgba(23,32,51,.04); }
        .admin-card-header { padding:18px 20px; border-bottom:1px solid #edf0f5; display:flex; justify-content:space-between; align-items:center; gap:12px; }
        .admin-card-header h2 { font-size:16px; margin:0; color:#172033; font-weight:700; }
        .admin-card-body { padding:20px; }
        .admin-stat { padding:20px; }
        .admin-stat-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; background:#eef2ff; color:var(--admin-blue); font-size:21px; }
        .admin-stat-label { color:#7b8799; font-size:12px; text-transform:uppercase; letter-spacing:.04em; font-weight:600; margin-top:16px; }
        .admin-stat-value { font-size:28px; font-weight:750; color:#172033; line-height:1.1; margin-top:4px; }
        .admin-stat-note { color:#94a3b8; font-size:12px; margin-top:7px; }
        .admin-table { width:100%; border-collapse:collapse; }
        .admin-table th { background:#f8fafc; color:#64748b; font-size:11px; text-transform:uppercase; letter-spacing:.04em; font-weight:700; padding:13px 16px; border-bottom:1px solid #e8ecf3; white-space:nowrap; }
        .admin-table td { padding:14px 16px; border-bottom:1px solid #eef1f5; color:#334155; font-size:14px; vertical-align:middle; }
        .admin-table tr:last-child td { border-bottom:0; }
        .admin-table tr:hover td { background:#fbfcff; }
        .admin-muted { color:#94a3b8; }
        .admin-badge { display:inline-flex; align-items:center; gap:5px; border-radius:999px; padding:5px 9px; font-size:11px; font-weight:700; }
        .badge-blue { background:#eef2ff; color:#4f46e5; }
        .badge-green { background:#ecfdf3; color:#15803d; }
        .badge-yellow { background:#fff8db; color:#a16207; }
        .badge-red { background:#fff1f2; color:#be123c; }
        .admin-btn { border:0; border-radius:8px; padding:9px 13px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:7px; cursor:pointer; }
        .admin-btn-primary { background:var(--admin-blue); color:#fff; }
        .admin-btn-primary:hover { color:#fff; background:#4338ca; }
        .admin-btn-light { background:#f1f5f9; color:#334155; }
        .admin-btn-danger { background:#fff1f2; color:#be123c; }
        .admin-btn-danger:hover { background:#ffe4e6; color:#9f1239; }
        .admin-btn-success { background:#ecfdf3; color:#15803d; }
        .admin-form-control { width:100%; border:1px solid #dce2eb; border-radius:8px; padding:10px 12px; outline:none; font-size:14px; background:#fff; }
        .admin-form-control:focus { border-color:#818cf8; box-shadow:0 0 0 3px rgba(99,102,241,.1); }
        .admin-form-label { display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:6px; }
        .admin-alert { padding:12px 15px; border-radius:9px; margin-bottom:18px; background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; }
        .admin-empty { padding:50px 20px; text-align:center; color:#94a3b8; }
        .admin-empty i { font-size:35px; display:block; margin-bottom:10px; color:#cbd5e1; }
        .admin-pagination { padding:16px 20px; border-top:1px solid #edf0f5; }
        .admin-mobile-toggle { display:none; border:0; background:transparent; font-size:23px; color:#334155; }
        .admin-overlay { display:none; }
        @media(max-width:900px) {
            .admin-sidebar { transform:translateX(-100%); transition:.2s ease; }
            .admin-shell.sidebar-open .admin-sidebar { transform:translateX(0); }
            .admin-main { margin-left:0; }
            .admin-mobile-toggle { display:inline-flex; }
            .admin-overlay { display:block; position:fixed; inset:0; background:rgba(15,23,42,.45); z-index:1030; opacity:0; pointer-events:none; transition:.2s; }
            .admin-shell.sidebar-open .admin-overlay { opacity:1; pointer-events:auto; }
            .admin-content { padding:20px 15px; }
            .admin-page-head { align-items:flex-start; flex-direction:column; }
        }
        @media(max-width:600px) {
            .admin-topbar { padding:0 15px; }
            .admin-topbar-title { display:none; }
            .admin-table { min-width:760px; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="admin-shell" id="adminShell">
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('backend/assets/images/logo.png') }}" alt="Homestay Finder"></a>
        </div>
        <nav>
            <div class="admin-section">Admin</div>
            <ul class="admin-nav">
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}"><i class="ti ti-dashboard"></i> Dashboard</a></li>
                <li class="{{ request()->routeIs('admin.homestays*') ? 'active' : '' }}"><a href="{{ route('admin.homestays') }}"><i class="ti ti-building"></i> Manage Homestays</a></li>
                <li class="{{ request()->routeIs('admin.reviews*') ? 'active' : '' }}"><a href="{{ route('admin.reviews') }}"><i class="ti ti-star"></i> Manage Reviews</a></li>
                <li class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}"><a href="{{ route('admin.users') }}"><i class="ti ti-users"></i> Manage Users</a></li>
                <li class="{{ request()->routeIs('admin.hosts*') ? 'active' : '' }}"><a href="{{ route('admin.hosts') }}"><i class="ti ti-home"></i> Manage Hosts</a></li>
            </ul>
            <div class="admin-section">Website</div>
            <ul class="admin-nav">
                <li><a href="{{ route('home') }}"><i class="ti ti-arrow-left"></i> Back to Website</a></li>
            </ul>
        </nav>
    </aside>
    <div class="admin-overlay" id="adminOverlay"></div>

    <main class="admin-main">
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="admin-mobile-toggle" id="adminMenuButton" type="button"><i class="ti ti-menu-2"></i></button>
                <span class="admin-topbar-title">Homestay Finder Admin</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="admin-muted d-none d-sm-inline">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="admin-btn admin-btn-light"><i class="ti ti-logout"></i> Logout</button>
                </form>
            </div>
        </header>
        <section class="admin-content">
            @if (session('success'))
                <div class="admin-alert"><i class="ti ti-circle-check me-1"></i>{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </section>
    </main>
</div>
<script>
    const shell = document.getElementById('adminShell');
    const menu = document.getElementById('adminMenuButton');
    const overlay = document.getElementById('adminOverlay');
    if (menu) menu.addEventListener('click', () => shell.classList.toggle('sidebar-open'));
    if (overlay) overlay.addEventListener('click', () => shell.classList.remove('sidebar-open'));
</script>
@stack('scripts')
</body>
</html>
