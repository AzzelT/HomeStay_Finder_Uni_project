@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">

            <h2 class="auth-title">Welcome back</h2>
            <p class="text-muted small mb-2">Sign in to your Homestay Finder account</p>
            <div class="auth-divider"></div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                        placeholder="you@email.com" autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">Remember me</label>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                </button>

                <p class="text-center text-muted small mb-0">
                    Don't have an account?
                    <a href="{{ route('register') }}" style="color:var(--primary);font-weight:600">
                        Register here
                    </a>
                </p>
            </form>

        </div>
    </div>
@endsection
