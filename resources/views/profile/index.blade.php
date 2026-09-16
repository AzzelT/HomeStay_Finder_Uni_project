@extends('layouts.app')

@section('title', 'My Profile')

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

                {{-- Update profile --}}
                <div class="profile-card">
                    <h5 class="profile-card-title">
                        <i class="bi bi-person-gear me-2"></i> Profile Information
                    </h5>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Full name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', Auth::user()->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="email">Email address</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', Auth::user()->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="bi bi-check-circle me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Update password --}}
                <div class="profile-card">
                    <h5 class="profile-card-title">
                        <i class="bi bi-lock me-2"></i> Change Password
                    </h5>

                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label" for="current_password">Current password</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    placeholder="Enter current password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="password">New password</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimum 8 characters">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="password_confirmation">Confirm new password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Repeat new password">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="bi bi-lock me-1"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
