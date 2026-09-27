@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Homestay Finder Cambodia</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            :root {
                --primary: #1a6b4a;
                --primary-dark: #124d36;
                --accent: #f5a623;
                --light-bg: #f8f9fa;
            }

            body {
                font-family: 'Segoe UI', sans-serif;
            }

            /* Navbar */
            .navbar {
                background-color: var(--primary);
            }

            .navbar-brand,
            .nav-link {
                color: #fff !important;
            }

            .nav-link:hover {
                color: var(--accent) !important;
            }

            /* Hero */
            .hero {
                background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                    url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600') center/cover no-repeat;
                min-height: 520px;
                display: flex;
                align-items: center;
                color: #fff;
            }

            .hero h1 {
                font-size: 3rem;
                font-weight: 700;
            }

            .hero p {
                font-size: 1.2rem;
                opacity: 0.9;
            }

            /* Search bar on hero */
            .hero-search {
                background: #fff;
                border-radius: 12px;
                padding: 1.5rem;
                margin-top: 2rem;
            }

            /* Section titles */
            .section-title {
                font-size: 1.8rem;
                font-weight: 700;
                color: var(--primary);
                margin-bottom: 0.5rem;
            }

            .section-divider {
                width: 60px;
                height: 4px;
                background: var(--accent);
                border-radius: 2px;
                margin-bottom: 2rem;
            }

            /* Hotel cards */
            .hotel-card {
                border: none;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
                transition: transform 0.2s, box-shadow 0.2s;
                height: 100%;
            }

            .hotel-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            }

            .hotel-card img {
                height: 200px;
                object-fit: cover;
                width: 100%;
            }

            .hotel-card .card-body {
                padding: 1.2rem;
            }

            .hotel-card .card-title {
                font-weight: 600;
                font-size: 1.1rem;
                color: #1a1a1a;
            }

            .badge-star {
                background-color: var(--accent);
                color: #fff;
                font-size: 0.8rem;
                padding: 4px 10px;
                border-radius: 20px;
            }

            .price-tag {
                font-weight: 700;
                color: var(--primary);
                font-size: 1.1rem;
            }

            .btn-primary-custom {
                background-color: var(--primary);
                border: none;
                color: #fff;
                border-radius: 8px;
            }

            .btn-primary-custom:hover {
                background-color: var(--primary-dark);
                color: #fff;
            }

            /* Footer */
            footer {
                background-color: var(--primary-dark);
                color: #ccc;
            }

            footer a {
                color: #aaa;
                text-decoration: none;
            }

            footer a:hover {
                color: var(--accent);
            }
        </style>
    </head>

    <body>

        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
                    <i class="bi bi-house-heart-fill me-2"></i>Homestay Finder
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('hotels.search') }}">Search</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                        {{-- Panha's auth links go here later --}}
                        <li class="nav-item ms-2">
                            <a class="btn btn-warning btn-sm fw-bold" href="#">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <section class="hero">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Find Your Perfect Stay in Cambodia</h1>
                        <p>Discover hotels, guesthouses, and resorts across all provinces</p>

                        {{-- Quick search bar --}}
                        <div class="hero-search">
                            <form action="{{ route('hotels.search') }}" method="GET">
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-8">
                                        <input type="text" name="name" class="form-control form-control-lg"
                                            placeholder="Search hotels, guesthouses...">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-lg w-100 btn-primary-custom">
                                            <i class="bi bi-search me-1"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Featured Hotels Section --}}
        <section class="py-5" style="background: var(--light-bg);">
            <div class="container">
                <h2 class="section-title">Featured Hotels</h2>
                <div class="section-divider"></div>

                <div class="row g-4">
                    @forelse ($featuredHotels as $hotel)
                        <div class="col-md-6 col-lg-4">
                            <div class="card hotel-card">
                                {{-- Hotel image --}}
                                @if ($hotel->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $hotel->images->first()->image_path) }}"
                                        alt="{{ $hotel->name }}">
                                @else
                                    <img src="https://via.placeholder.com/400x200?text=No+Image" alt="No image">
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h5 class="card-title mb-0">{{ $hotel->name }}</h5>
                                        <span class="badge-star">
                                            {{ $hotel->star_rating }} <i class="bi bi-star-fill"></i>
                                        </span>
                                    </div>

                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-geo-alt-fill me-1"></i>
                                        {{ $hotel->province->name ?? 'Unknown' }}
                                    </p>

                                    <p class="text-muted small mb-3"
                                        style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        {{ $hotel->description }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span
                                            class="price-tag">${{ number_format($hotel->price_per_night, 0) }}/night</span>
                                        <a href="{{ route('hotels.show', $hotel->id) }}"
                                            class="btn btn-sm btn-primary-custom">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-building fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No hotels available yet.</p>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('hotels.search') }}" class="btn btn-lg btn-primary-custom px-5">
                        View All Hotels <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="py-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h6 class="text-white fw-bold">Homestay Finder</h6>
                        <p class="small">Helping you find the best stays across Cambodia.</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6 class="text-white fw-bold">Quick Links</h6>
                        <ul class="list-unstyled small">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('hotels.search') }}">Search Hotels</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6 class="text-white fw-bold">Contact Us</h6>
                        <p class="small">
                            <i class="bi bi-telegram me-1"></i>
                            <a href="https://t.me/yourtelegram" target="_blank">@HomestayFinder</a>
                        </p>
                    </div>
                </div>
                <hr style="border-color: #ffffff30;">
                <p class="text-center small mb-0">© {{ date('Y') }} Homestay Finder. All rights reserved.</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
@endsection
