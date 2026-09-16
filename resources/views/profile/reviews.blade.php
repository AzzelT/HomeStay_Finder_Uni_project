@extends('layouts.app')

@section('title', 'My Reviews')

@section('content')
    <div class="container py-4">
        <div class="row g-4">

            {{-- ── Sidebar ───────────────────────────────────────────────────── --}}
            <div class="col-lg-3">
                {{-- User info --}}
                <div class="profile-card text-center mb-3">
                    <div class="profile-avatar mx-auto mb-3">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h6 class="fw-bold mb-0" style="font-family:var(--font-heading)">
                        {{ Auth::user()->name }}
                    </h6>
                    <p class="text-muted small mt-1 mb-0">{{ Auth::user()->email }}</p>
                </div>

                {{-- Nav links --}}
                <div class="profile-nav">
                    <a href="{{ route('profile.index') }}"
                        class="profile-nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                        <i class="bi bi-person"></i> My Profile
                    </a>
                    <a href="{{ route('profile.reviews') }}"
                        class="profile-nav-link {{ request()->routeIs('profile.reviews') ? 'active' : '' }}">
                        <i class="bi bi-star"></i> My Reviews
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="profile-nav-link w-100 border-0 bg-transparent text-danger">
                            <i class="bi bi-box-arrow-right"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── Main Content ──────────────────────────────────────────────── --}}
            <div class="col-lg-9">
                <div class="profile-card">
                    <h5 class="profile-card-title">
                        <i class="bi bi-star me-2"></i> My Reviews
                        <span class="text-muted fw-normal fs-6 ms-1">({{ $reviews->count() }})</span>
                    </h5>

                    @forelse ($reviews as $review)
                        <div class="review-item">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                <div>
                                    {{-- Hotel name --}}
                                    <a href="{{ route('hotels.show', $review->hotel->id) }}" class="review-hotel-name">
                                        <i class="bi bi-building me-1"></i>
                                        {{ $review->hotel->name }}
                                    </a>

                                    {{-- Stars --}}
                                    <div class="review-stars mt-1 mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                        <span class="text-muted small ms-1">{{ $review->rating }}/5</span>
                                    </div>

                                    {{-- Comment --}}
                                    @if ($review->comment)
                                        <p class="text-muted small mb-0">{{ $review->comment }}</p>
                                    @endif
                                </div>

                                <div class="text-end">
                                    {{-- Date --}}
                                    <p class="review-date mb-2">
                                        {{ $review->created_at->format('d M Y') }}
                                    </p>

                                    {{-- Delete button --}}
                                    <form method="POST" action="{{ route('reviews.destroy', $review->id) }}"
                                        onsubmit="return confirm('Delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            style="border-radius:var(--radius-sm)">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-star fs-1"></i>
                            <p class="mt-3">You haven't written any reviews yet.</p>
                            <a href="{{ route('hotels.index') }}" class="btn btn-primary-custom btn-sm">
                                Browse Hotels
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
