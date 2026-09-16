@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">

            <h2 class="auth-title">Create account</h2>
            <p class="text-muted small mb-2">Join Homestay Finder and start exploring</p>
            <div class="auth-divider"></div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label" for="name">Full name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                        placeholder="Your full name" autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                        placeholder="you@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 characters">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-4">
                    <label class="form-label" for="password_confirmation">Confirm password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="Repeat your password">
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                    <i class="bi bi-person-plus me-2"></i> Create Account
                </button>

                <p class="text-center text-muted small mb-0">
                    Already have an account?
                    <a href="{{ route('login') }}" style="color:var(--primary);font-weight:600">
                        Sign in here
                    </a>
                </p>
            </form>

        </div>
    </div>
@endsection
