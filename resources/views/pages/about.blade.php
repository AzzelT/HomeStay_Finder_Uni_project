@extends('layouts.app')

@section('title', 'About Us')

@push('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, var(--primary), #0a362b);
        color: #fff;
        padding: 90px 0;
        border-radius: 0 0 var(--radius-xl) var(--radius-xl);
    }

    .feature-box {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        text-align: center;
        box-shadow: var(--shadow-subtle);
        transition: all 0.2s ease;
    }

    .feature-box:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card);
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: var(--primary);
    }

    .team-card {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-subtle);
        text-align: center;
        padding: 1.5rem 1rem;
        transition: all 0.2s ease;
    }

    .team-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card);
    }

    .team-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), #156d56);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0 auto 1rem;
        font-family: var(--font-heading);
    }
</style>
@endpush

@section('content')

{{-- Hero --}}
<section class="about-hero text-center">
    <div class="container">
        <p class="hero-tagline">Who We Are</p>
        <h1 class="hero-title">About Homestay Finder</h1>
        <p class="mx-auto mt-3" style="max-width:580px;opacity:0.88;font-size:1.1rem">
            Helping travelers discover the best hotels, guesthouses, and resorts
            across all provinces of Cambodia — all in one place.
        </p>
    </div>
</section>

{{-- Mission --}}
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <h2 style="font-family:var(--font-heading);color:var(--primary)">Our Mission</h2>
                <p class="mt-3" style="color:var(--slate);line-height:1.8">
                    Homestay Finder was built to make it easier for both local and
                    international travelers to find quality accommodation in Cambodia.
                    We believe everyone deserves a comfortable, well-informed stay —
                    no matter their budget or destination.
                </p>
                <p style="color:var(--slate);line-height:1.8">
                    From budget guesthouses in Phnom Penh to beachside resorts in
                    Sihanoukville, we bring all your options together with honest
                    reviews and direct booking links.
                </p>
            </div>
            <div class="col-md-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="feature-box">
                            <div class="feature-icon"><i class="bi bi-building"></i></div>
                            <h5 class="fw-bold" style="font-family:var(--font-heading)">100+ Hotels</h5>
                            <p class="text-muted small mb-0">Across all provinces</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-box">
                            <div class="feature-icon"><i class="bi bi-people"></i></div>
                            <h5 class="fw-bold" style="font-family:var(--font-heading)">Verified Reviews</h5>
                            <p class="text-muted small mb-0">From real guests</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-box">
                            <div class="feature-icon"><i class="bi bi-geo-alt"></i></div>
                            <h5 class="fw-bold" style="font-family:var(--font-heading)">25 Provinces</h5>
                            <p class="text-muted small mb-0">Nationwide coverage</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-box">
                            <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                            <h5 class="fw-bold" style="font-family:var(--font-heading)">Free to Use</h5>
                            <p class="text-muted small mb-0">No hidden fees</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Team --}}
<section class="py-5" style="background:var(--light-bg)">
    <div class="container">
        <h2 class="text-center fw-bold mb-1" style="font-family:var(--font-heading);color:var(--primary)">
            Our Team
        </h2>
        <p class="text-center text-muted mb-4">Year 2 CS students at UTE Cambodia</p>

        <div class="row g-3 justify-content-center">
            @foreach ([
                ['R',  'Roby',     'Frontend & UI Designer'],
                ['P',  'Panha',    'Auth & User Profiles'],
                ['H',  'HengLeap', 'Homestay CRUD & Reviews'],
                ['T',  'Tola',     'Search & Public Features'],
                ['Ra', 'Ratana',   'Admin Dashboard & Hotels'],
            ] as $m)
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="team-card">
                        <div class="team-avatar">{{ $m[0] }}</div>
                        <h6 class="fw-bold mb-0" style="font-family:var(--font-heading)">
                            {{ $m[1] }}
                        </h6>
                        <p class="text-muted small mt-1 mb-0">{{ $m[2] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
