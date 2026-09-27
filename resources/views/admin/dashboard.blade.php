@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

{{-- Dashboard Header --}}
<div class="admin-page-head">
    <div>
        <h1>Admin Dashboard</h1>
        <p>Manage your HomestayFinder platform from one place.</p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a class="admin-btn admin-btn-light" href="{{ route('admin.users.index') }}">
            <i class="bi bi-people-fill"></i>
            Users
        </a>

        <a class="admin-btn admin-btn-primary" href="{{ route('admin.reviews') }}">
            <i class="bi bi-star-fill"></i>
            Reviews
        </a>
    </div>
</div>


{{-- Statistics --}}
<div class="row g-3 mb-4">

    {{-- Users --}}
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card h-100">
            <div class="admin-stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>

            <div class="admin-stat-number">
                {{ $stats['users'] }}
            </div>

            <div class="admin-stat-label">
                Total Users
            </div>
        </div>
    </div>

    {{-- Hosts --}}
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card h-100">
            <div class="admin-stat-icon">
                <i class="bi bi-person-badge-fill"></i>
            </div>

            <div class="admin-stat-number">
                {{ $stats['hosts'] }}
            </div>

            <div class="admin-stat-label">
                Host Accounts
            </div>
        </div>
    </div>

    {{-- Homestays --}}
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card h-100">
            <div class="admin-stat-icon">
                <i class="bi bi-buildings-fill"></i>
            </div>

            <div class="admin-stat-number">
                {{ $stats['homestays'] }}
            </div>

            <div class="admin-stat-label">
                Listed Homestays
            </div>
        </div>
    </div>

    {{-- Reviews --}}
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card h-100">
            <div class="admin-stat-icon">
                <i class="bi bi-star-fill"></i>
            </div>

            <div class="admin-stat-number">
                {{ $stats['reviews'] }}
            </div>

            <div class="admin-stat-label">
                Guest Reviews
            </div>
        </div>
    </div>

</div>


{{-- Main Dashboard --}}
<div class="row g-3">

    {{-- Recent Reviews --}}
    <div class="col-xl-8">

        <div class="admin-card h-100">

            <div class="admin-card-header">
                <h2>
                    Recent Reviews
                </h2>

                <a class="admin-btn admin-btn-light"
                   href="{{ route('admin.reviews') }}">
                    View all
                </a>
            </div>

            <div class="table-responsive">

                <table class="admin-table">

                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Homestay</th>
                            <th>Rating</th>
                            <th>Comment</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recentReviews as $review)

                            <tr>

                                <td>
                                    <strong>{{ $review->user_name }}</strong>
                                </td>

                                <td>
                                    {{ $review->hotel_name }}
                                </td>

                                <td>
                                    <span class="admin-badge badge-gold">
                                        <i class="bi bi-star-fill"></i>
                                        {{ $review->rating }}/5
                                    </span>
                                </td>

                                <td>
                                    {{ $review->comment ?: 'No comment' }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4">

                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-chat-square-text fs-4 d-block mb-2"></i>
                                        No reviews yet.
                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Admin Tools --}}
    <div class="col-xl-4">

        <div class="admin-card h-100">

            <div class="admin-card-header">
                <h2>Admin Tools</h2>
            </div>

            <div class="admin-card-body">

                <div class="d-grid gap-2">

                    <a class="admin-btn admin-btn-light justify-content-start"
                       href="{{ route('admin.homestays') }}">
                        <i class="bi bi-buildings-fill"></i>
                        Manage Homestays
                    </a>

                    <a class="admin-btn admin-btn-light justify-content-start"
                       href="{{ route('admin.reviews') }}">
                        <i class="bi bi-star-fill"></i>
                        Manage Reviews
                    </a>

                    <a class="admin-btn admin-btn-light justify-content-start"
                       href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people-fill"></i>
                        Manage Users
                    </a>

                    <a class="admin-btn admin-btn-light justify-content-start"
                       href="{{ route('admin.hosts') }}">
                        <i class="bi bi-person-badge-fill"></i>
                        Manage Hosts
                    </a>

                </div>


                {{-- Average Rating --}}
                <div class="mt-4 p-3 rounded-3"
                     style="background:var(--primary-light);">

                    <div class="text-muted"
                         style="font-size:12px;">
                        Average Rating
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-1">

                        <strong style="
                            font-family:var(--font-heading);
                            font-size:26px;
                            color:var(--primary);
                        ">
                            {{ $averageRating ? number_format($averageRating, 1) : '0.0' }}
                        </strong>

                        <span class="text-muted">
                            / 5
                        </span>

                        <i class="bi bi-star-fill"
                           style="color:var(--accent);">
                        </i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
```

@endsection
