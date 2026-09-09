<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Homestay Finder') - Discover Authentic Hotels & Homestays</title>
    <meta name="description" content="@yield('meta_description', 'Discover and book authentic homestays, boutique hotels, and luxury resorts across Cambodia. Directly connect with hosts.')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/app-custom.css') }}">

    @stack('styles')
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="brand-logo" href="{{ route('home') }}">
                <span class="brand-icon">
                    <i class="bi bi-house-heart-fill"></i>
                </span>
                <span>Homestay<span style="color: var(--accent);">Finder</span></span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <i class="bi bi-list fs-2 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('hotels.*') ? 'active' : '' }}" href="{{ route('hotels.index') }}">
                            <i class="bi bi-building me-1"></i> Explore Homestays
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            <i class="bi bi-info-circle me-1"></i> About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            <i class="bi bi-envelope me-1"></i> Contact & Support
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @auth
                        <!-- User Dropdown Menu -->
                        <div class="dropdown">
                            <button class="btn btn-outline-light text-dark d-flex align-items-center gap-2 border rounded-pill px-3 py-1 shadow-sm" type="button" data-bs-toggle="dropdown">
                                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="rounded-circle" width="32" height="32" style="object-fit: cover;">
                                <span class="fw-semibold text-truncate" style="max-width: 130px;">{{ Auth::user()->name }}</span>
                                <i class="bi bi-chevron-down text-muted small"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2 p-2" style="min-width: 220px;">
                                <li class="px-3 py-2 border-bottom mb-1">
                                    <div class="small text-muted">Signed in as</div>
                                    <div class="fw-bold text-dark text-truncate">{{ Auth::user()->email }}</div>
                                    @if(Auth::user()->isAdmin())
                                        <span class="badge bg-success-subtle text-success mt-1">Administrator</span>
                                    @endif
                                </li>
                                @if(Auth::user()->isAdmin())
                                    <li>
                                        <a class="dropdown-item rounded-2 py-2 text-primary fw-semibold" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <a class="dropdown-item rounded-2 py-2" href="{{ route('profile.index') }}">
                                        <i class="bi bi-person-gear me-2"></i> Profile & Settings
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-2 py-2" href="{{ route('profile.reviews') }}">
                                        <i class="bi bi-star me-2"></i> My Reviews
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded-2 py-2 text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary-custom btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-sm">
                            <i class="bi bi-person-plus me-1"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Alerts Container -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <div class="fw-semibold mb-1"><i class="bi bi-exclamation-circle me-1"></i> Please check the following errors:</div>
                <ul class="mb-0 ps-3 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-custom pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4 col-md-6">
                    <a class="brand-logo text-white mb-3" href="{{ route('home') }}">
                        <span class="brand-icon">
                            <i class="bi bi-house-heart-fill"></i>
                        </span>
                        <span>Homestay<span style="color: var(--accent);">Finder</span></span>
                    </a>
                    <p class="text-secondary small pe-lg-4 mt-3">
                        Your trusted portal to authentic homestays, boutique hotels, and secluded eco-resorts across Cambodia. Directly connect with verified hosts with zero hidden fees.
                    </p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="https://t.me/homestayfindersupport" target="_blank" class="btn btn-telegram btn-sm">
                            <i class="bi bi-telegram fs-6"></i> Telegram Support
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="text-white fw-bold mb-3">Popular Destinations</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('hotels.index', ['province_id' => 1]) }}" class="footer-link">Siem Reap (Angkor)</a></li>
                        <li><a href="{{ route('hotels.index', ['province_id' => 2]) }}" class="footer-link">Kampot River</a></li>
                        <li><a href="{{ route('hotels.index', ['province_id' => 3]) }}" class="footer-link">Koh Rong Island</a></li>
                        <li><a href="{{ route('hotels.index', ['province_id' => 4]) }}" class="footer-link">Phnom Penh Capital</a></li>
                        <li><a href="{{ route('hotels.index', ['province_id' => 5]) }}" class="footer-link">Mondulkiri Highlands</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="text-white fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('hotels.index') }}" class="footer-link">All Accommodations</a></li>
                        <li><a href="{{ route('about') }}" class="footer-link">About Our Mission</a></li>
                        <li><a href="{{ route('contact') }}" class="footer-link">Contact & Help</a></li>
                        @auth
                            <li><a href="{{ route('profile.index') }}" class="footer-link">My Account</a></li>
                            <li><a href="{{ route('profile.reviews') }}" class="footer-link">My Reviews</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="footer-link">Host / Guest Login</a></li>
                            <li><a href="{{ route('register') }}" class="footer-link">Create Account</a></li>
                        @endauth
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h6 class="text-white fw-bold mb-3">Customer Support</h6>
                    <p class="text-secondary small mb-2">
                        Need assistance with a homestay booking or listing your property? Our local concierge team is available 24/7.
                    </p>
                    <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mt-3">
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt text-warning"></i> #42 Riverside Boulevard, Phnom Penh, Cambodia
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-telephone text-warning"></i> +855 23 999 888
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope text-warning"></i> support@homestayfinder.com
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary opacity-25">

            <div class="row align-items-center small text-secondary">
                <div class="col-md-6 text-center text-md-start">
                    &copy; {{ date('Y') }} Homestay Finder. All rights reserved.
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <span class="badge bg-dark border border-secondary text-secondary">Laravel 11 & MySQL</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
