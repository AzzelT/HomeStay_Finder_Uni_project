@extends('layouts.app')

@section('title', 'Home')

@push('styles')
    <style>
        .section-title {
            font-family: var(--font-heading);
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--dark);
        }

        .section-divider {
            width: 56px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
            margin-bottom: 2rem;
        }

        .star-display {
            color: #f59e0b;
        }
    </style>
@endpush

@section('content')

    {{-- ── Hero ─────────────────────────────────────────────────────────────── --}}
    <section class="hero-wrapper">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <p class="hero-tagline">Cambodia's #1 Homestay Platform</p>
                    <h1 class="hero-title">Find Your Perfect Stay<br>Across Cambodia</h1>
                    <p style="opacity:0.85; font-size:1.1rem;">
                        Discover hotels, guesthouses, and resorts across all provinces
                    </p>

                    <div class="hero-search-card">
                        <form action="{{ route('hotels.index') }}" method="GET">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-8">
                                    <input type="text" name="name" class="form-control form-control-lg"
                                        placeholder="Search hotels, guesthouses..."
                                        style="border-radius:var(--radius-md);border-color:var(--card-border)">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary-custom btn-lg w-100">
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

    {{-- ── Featured Hotels ─────────────────────────────────────────────────── --}}
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Featured Hotels</h2>
            <div class="section-divider"></div>

            <div class="row g-4">
                @forelse ($featuredHotels as $hotel)
                    <div class="col-md-6 col-lg-4">
                        <div class="hotel-card">
                            <div class="hotel-card-img-wrapper">
                                @if ($hotel->images->isNotEmpty())
                                    <img class="hotel-card-img"
                                        src="{{ asset('storage/' . $hotel->images->first()->image_path) }}"
                                        alt="{{ $hotel->name }}">
                                @else
                                    <img class="hotel-card-img" src="https://placehold.co/400x220?text=No+Image"
                                        alt="No image">
                                @endif

                                @if ($hotel->star_rating)
                                    <span class="hotel-type-badge">
                                        {{ $hotel->star_rating }}
                                        <i class="bi bi-star-fill ms-1" style="color:#f59e0b"></i>
                                    </span>
                                @endif

                                <span class="hotel-price-badge">
                                    ${{ number_format($hotel->price_per_night, 0) }}/night
                                </span>
                            </div>

                            <div class="hotel-card-body">
                                <h5 class="fw-bold mb-1" style="font-family:var(--font-heading)">
                                    {{ $hotel->name }}
                                </h5>

                                <p class="text-muted small mb-2">
                                    <i class="bi bi-geo-alt-fill me-1" style="color:var(--primary)"></i>
                                    {{ $hotel->province->name ?? 'Cambodia' }}
                                </p>

                                <p class="text-muted small mb-3"
                                    style="overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                                    {{ $hotel->description ?? 'No description available.' }}
                                </p>

                                <div class="mt-auto">
                                    <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-primary-custom w-100">
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
                <a href="{{ route('hotels.index') }}" class="btn btn-primary-custom btn-lg px-5">
                    View All Hotels <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

@endsection
