@extends('layouts.app')

@section('title', 'Contact Us')

@push('styles')
<style>
    .contact-card {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        padding: 2.5rem;
    }

    .contact-icon-box {
        width: 52px;
        height: 52px;
        border-radius: var(--radius-sm);
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--primary);
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="text-center mb-4">
                <h2 class="fw-bold" style="font-family:var(--font-heading);color:var(--primary)">
                    Contact Us
                </h2>
                <p class="text-muted">Have a question? Reach us on Telegram — we reply fast.</p>
            </div>

            <div class="contact-card">

                {{-- Telegram CTA --}}
                <div class="text-center mb-4">
                    <div class="mb-3" style="font-size:3rem;color:#24A1DE">
                        <i class="bi bi-telegram"></i>
                    </div>
                    <h5 class="fw-bold" style="font-family:var(--font-heading)">
                        Chat with us on Telegram
                    </h5>
                    <p class="text-muted small mb-4">
                        Available every day. Fastest way to reach our team.
                    </p>
                    {{-- Replace @yourteamusername with your real Telegram username --}}
                    <a href="https://t.me/yourteamusername" target="_blank" class="btn btn-telegram w-100">
                        <i class="bi bi-telegram"></i> Open Telegram Chat
                    </a>
                </div>

                <hr style="border-color:var(--card-border)">

                {{-- Contact info --}}
                <div class="d-flex flex-column gap-3 mt-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="contact-icon-box"><i class="bi bi-envelope"></i></div>
                        <div>
                            <p class="fw-semibold mb-0 small">Email</p>
                            <p class="text-muted small mb-0">homestayfinder@email.com</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="contact-icon-box"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <p class="fw-semibold mb-0 small">Location</p>
                            <p class="text-muted small mb-0">Phnom Penh, Cambodia</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="contact-icon-box"><i class="bi bi-clock"></i></div>
                        <div>
                            <p class="fw-semibold mb-0 small">Response Time</p>
                            <p class="text-muted small mb-0">Usually within a few hours</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
