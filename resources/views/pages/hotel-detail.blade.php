@extends('layouts.app')

@section('title', $hotel->name)

@push('styles')
    <style>
        .main-photo {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: var(--radius-lg);
        }

        .thumb-row {
            display: flex;
            gap: 8px;
            margin-top: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .thumb-row img {
            width: 90px;
            height: 68px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            cursor: pointer;
            opacity: 0.65;
            transition: opacity 0.2s;
            flex-shrink: 0;
        }

        .thumb-row img:hover,
        .thumb-row img.active {
            opacity: 1;
            outline: 2px solid var(--primary);
        }

        .info-card {
            background: #fff;
            border-radius: var(--radius-md);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-subtle);
            padding: 1.4rem;
            margin-bottom: 1.2rem;
        }

        .review-card {
            background: #fff;
            border-radius: var(--radius-md);
            border: 1px solid var(--card-border);
            padding: 1rem 1.2rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-subtle);
        }

        .review-stars {
            color: #f59e0b;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #156d56);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }

        .btn-book-now {
            background: linear-gradient(135deg, var(--accent), #e5b839);
            color: #1e1e1e;
            font-weight: 700;
            font-size: 1.05rem;
            border: none;
            border-radius: var(--radius-md);
            padding: 14px 0;
            width: 100%;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(212, 175, 55, 0.3);
            display: block;
            text-align: center;
            text-decoration: none;
        }

        .btn-book-now:hover {
            background: linear-gradient(135deg, #b89025, var(--accent));
            color: #1e1e1e;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }

        .btn-facebook-page {
            background-color: #1877f2;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: var(--radius-md);
            padding: 11px 0;
            width: 100%;
            transition: all 0.2s ease;
            display: block;
            text-align: center;
            text-decoration: none;
        }

        .btn-facebook-page:hover {
            background-color: #145dbf;
            color: #fff;
            transform: translateY(-1px);
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color:var(--primary)">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('hotels.index') }}" style="color:var(--primary)">Search</a>
                </li>
                <li class="breadcrumb-item active">{{ $hotel->name }}</li>
            </ol>
        </nav>

        <div class="row g-4">

            {{-- ── Left: Photos + Info ──────────────────────────────────────── --}}
            <div class="col-lg-8">

                {{-- Photo gallery --}}
                @if ($hotel->images->isNotEmpty())
                    <img id="mainPhoto" src="{{ asset('storage/' . $hotel->images->first()->image_path) }}"
                        alt="{{ $hotel->name }}" class="main-photo">

                    @if ($hotel->images->count() > 1)
                        <div class="thumb-row">
                            @foreach ($hotel->images as $index => $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Photo {{ $index + 1 }}"
                                    class="{{ $index === 0 ? 'active' : '' }}"
                                    onclick="changePhoto(this, '{{ asset('storage/' . $image->image_path) }}')">
                            @endforeach
                        </div>
                    @endif
                @else
                    <img src="https://placehold.co/800x420?text=No+Photos" class="main-photo" alt="No photos">
                @endif

                {{-- Name + location --}}
                <div class="mt-4 mb-3">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <h1 class="fw-bold mb-1" style="font-family:var(--font-heading)">
                            {{ $hotel->name }}
                        </h1>
                        {{-- Star rating --}}
                        @if ($hotel->star_rating)
                            <div class="text-end">
                                <div class="review-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $hotel->star_rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <small class="text-muted">{{ $hotel->star_rating }}-Star Hotel</small>
                            </div>
                        @endif
                    </div>

                    <p class="mb-2" style="color:var(--slate)">
                        <i class="bi bi-geo-alt-fill me-1" style="color:var(--primary)"></i>
                        {{ $hotel->address }}, {{ $hotel->province->name ?? '' }}
                    </p>

                    {{-- Average review rating --}}
                    <div class="d-flex align-items-center gap-2">
                        <div class="review-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= round($averageRating) ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <span class="fw-semibold">{{ number_format($averageRating, 1) }}</span>
                        <span class="text-muted small">
                            ({{ $totalReviews }} review{{ $totalReviews != 1 ? 's' : '' }})
                        </span>
                    </div>
                </div>

                {{-- Description --}}
                <div class="info-card">
                    <h5 class="fw-bold mb-2" style="color:var(--primary);font-family:var(--font-heading)">
                        About this place
                    </h5>
                    <p class="mb-0" style="color:var(--slate);line-height:1.75">
                        {{ $hotel->description ?? 'No description available.' }}
                    </p>
                </div>

                {{-- Amenities --}}
                @if ($hotel->amenities->isNotEmpty())
                    <div class="info-card">
                        <h5 class="fw-bold mb-3" style="color:var(--primary);font-family:var(--font-heading)">
                            Amenities
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($hotel->amenities as $amenity)
                                <span class="amenity-pill">
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ $amenity->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Location --}}
                <div class="info-card">
                    <h5 class="fw-bold mb-2" style="color:var(--primary);font-family:var(--font-heading)">
                        Location
                    </h5>
                    <p class="mb-2" style="color:var(--slate)">
                        <i class="bi bi-geo-alt me-1"></i>
                        {{ $hotel->address }}, {{ $hotel->province->name ?? '' }}, Cambodia
                    </p>
                    @if ($hotel->google_maps_url)
                        <a href="{{ $hotel->google_maps_url }}" target="_blank"
                            class="btn btn-outline-primary-custom btn-sm">
                            <i class="bi bi-map me-1"></i> View on Google Maps
                        </a>
                    @endif
                </div>

                {{-- Reviews --}}
                <div class="mb-4">
                    <h5 class="fw-bold mb-3" style="font-family:var(--font-heading);color:var(--dark)">
                        Guest Reviews
                        <span class="text-muted fs-6 fw-normal ms-1">({{ $totalReviews }})</span>
                    </h5>

                    @forelse ($hotel->reviews as $review)
                        <div class="review-card">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="avatar-circle">
                                    {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-semibold">{{ $review->user->name ?? 'Anonymous' }}</span>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="review-stars mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="mb-0 small" style="color:var(--slate)">
                                        {{ $review->comment }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-chat-square-text fs-2"></i>
                            <p class="mt-2">No reviews yet. Be the first!</p>
                        </div>
                    @endforelse

                    {{-- Leave a review --}}
                    @auth
                        <div class="info-card mt-3">
                            <h6 class="fw-bold mb-3" style="font-family:var(--font-heading)">
                                Leave a Review
                            </h6>
                            {{-- HengLeap wires up the submit route --}}
                            <form action="#" method="POST">
                                @csrf
                                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Rating</label>
                                    <div class="star-rating-input">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" id="star{{ $i }}"
                                                value="{{ $i }}">
                                            <label for="star{{ $i }}">
                                                <i class="bi bi-star-fill"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Your Review</label>
                                    <textarea name="comment" class="form-control" rows="3" placeholder="Share your experience..."
                                        style="border-radius:var(--radius-sm)"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary-custom">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-3 rounded-3 mt-3"
                            style="background:var(--primary-light);border:1px solid rgba(14,75,60,0.15)">
                            <p class="mb-0 small">
                                <a href="{{ route('login') }}" style="color:var(--primary);font-weight:600">
                                    Login
                                </a>
                                to leave a review
                            </p>
                        </div>
                    @endauth
                </div>

            </div>

            {{-- ── Right: Booking Sidebar ───────────────────────────────────── --}}
            <div class="col-lg-4">
                <div class="sticky-booking-card">

                    {{-- Price --}}
                    <div class="text-center mb-4 py-3 rounded-3" style="background:var(--primary-light)">
                        <p class="mb-0 text-muted small">Price per night</p>
                        <h2 class="fw-bold mb-0" style="color:var(--primary);font-family:var(--font-heading)">
                            ${{ number_format($hotel->price_per_night, 0) }}
                        </h2>
                    </div>

                    {{-- Book Now --}}
                    @if ($hotel->website_url)
                        <a href="{{ $hotel->website_url }}" target="_blank" class="btn-book-now mb-2">
                            <i class="bi bi-box-arrow-up-right me-2"></i> Book Now
                        </a>
                    @endif

                    @if ($hotel->facebook_url)
                        <a href="{{ $hotel->facebook_url }}" target="_blank" class="btn-facebook-page mb-3">
                            <i class="bi bi-facebook me-2"></i> Visit Facebook Page
                        </a>
                    @endif

                    @if (!$hotel->website_url && !$hotel->facebook_url)
                        <div class="alert alert-warning small text-center py-2 rounded-3">
                            <i class="bi bi-clock me-1"></i> No booking link available yet
                        </div>
                    @endif

                    <hr style="border-color:var(--card-border)">

                    {{-- Quick info --}}
                    <ul class="list-unstyled small mb-0" style="color:var(--slate)">
                        <li class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-geo-alt" style="color:var(--primary)"></i>
                            {{ $hotel->province->name ?? 'Cambodia' }}
                        </li>
                        @if ($hotel->star_rating)
                            <li class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-building" style="color:var(--primary)"></i>
                                {{ $hotel->star_rating }}-Star Hotel
                            </li>
                        @endif
                        <li class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-star-fill" style="color:#f59e0b"></i>
                            {{ number_format($averageRating, 1) }} / 5
                            ({{ $totalReviews }} reviews)
                        </li>
                        @if ($hotel->google_maps_url)
                            <li class="d-flex align-items-center gap-2">
                                <i class="bi bi-map" style="color:var(--primary)"></i>
                                <a href="{{ $hotel->google_maps_url }}" target="_blank" style="color:var(--primary)">
                                    View on Google Maps
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function changePhoto(thumb, src) {
            document.getElementById('mainPhoto').src = src;
            document.querySelectorAll('.thumb-row img')
                .forEach(img => img.classList.remove('active'));
            thumb.classList.add('active');
        }
    </script>
@endpush
