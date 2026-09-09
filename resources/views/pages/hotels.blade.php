@extends('layouts.app')

@section('title', 'Contact Customer Service - Homestay Finder')
@section('meta_description', 'Contact our local concierge team via simple contact form or fast Telegram messaging. We are here to help 24/7.')

@section('content')
<!-- Header Banner -->
<div class="bg-light py-5 border-bottom mb-5">
    <div class="container text-center">
        <span class="text-uppercase fw-bold text-success small letter-spacing-1">Get In Touch</span>
        <h1 class="fw-bold text-dark mt-2 mb-3">Customer Service & Support</h1>
        <p class="text-muted mx-auto lead" style="max-width: 650px; font-size: 1.15rem;">
            Have questions about a destination, need booking assistance, or want to list your homestay? We’re here to assist you.
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5">
        <!-- Contact Form & Telegram Box (Left Column) -->
        <div class="col-lg-7">
            <!-- Telegram Fast Contact Banner (Required Feature) -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white" style="background: linear-gradient(135deg, #1d90c9 0%, #116892 100%);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white text-primary rounded-circle p-3 d-flex align-items-center justify-content-center shadow" style="width: 54px; height: 54px; color: #24A1DE !important;">
                            <i class="bi bi-telegram fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-white">Need Quick Help? Chat on Telegram</h5>
                            <span class="small text-white-50">Instant response from our concierge support team</span>
                        </div>
                    </div>
                    <a href="{{ $telegramLink }}" target="_blank" rel="noopener noreferrer" class="btn btn-light fw-bold px-4 py-2 rounded-pill shadow-sm" style="color: #116892;">
                        <i class="bi bi-send-fill me-1"></i> Open Telegram
                    </a>
                </div>
            </div>

            <!-- Standard Contact Form -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h4 class="fw-bold mb-2 text-dark">Send Us a Direct Message</h4>
                <p class="text-muted small mb-4">Fill out the form below and we will get back to you via email within 24 hours.</p>

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Your Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}" required placeholder="e.g. Sokha Chan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" required placeholder="name@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Phone Number (Optional)</label>
                            <input type="text" name="phone" class="form-control rounded-3" value="{{ old('phone', Auth::check() ? Auth::user()->phone : '') }}" placeholder="+855 12 345 678">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control rounded-3" value="{{ old('subject') }}" required placeholder="e.g. Booking inquiry or listing request">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Message <span class="text-danger">*</span></label>
                            <textarea name="message" rows="5" class="form-control rounded-3" required placeholder="How can our concierge assist you today?">{{ old('message') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary-custom px-4 py-2">
                                <i class="bi bi-send me-1"></i> Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Info & FAQs (Right Column) -->
        <div class="col-lg-5">
            <!-- Info Cards -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h5 class="fw-bold mb-3 text-dark">Concierge Office</h5>
                <ul class="list-unstyled small text-secondary d-flex flex-column gap-3 mb-0">
                    <li class="d-flex align-items-start gap-3">
                        <div class="brand-icon" style="width: 36px; height: 36px; font-size: 1rem;">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark">Office Address</strong>
                            {{ $officeAddress }}
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-3">
                        <div class="brand-icon" style="width: 36px; height: 36px; font-size: 1rem;">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark">Customer Service Line</strong>
                            <a href="tel:{{ $contactPhone }}" class="text-decoration-none text-muted">{{ $contactPhone }}</a>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-3">
                        <div class="brand-icon" style="width: 36px; height: 36px; font-size: 1rem;">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark">Support Email</strong>
                            <a href="mailto:{{ $contactEmail }}" class="text-decoration-none text-muted">{{ $contactEmail }}</a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- FAQs Accordion -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-3 text-dark">Frequently Asked Questions</h5>
                <div class="accordion accordion-flush" id="faqAccordion">
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button collapsed px-0 fw-semibold small" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                How do I book with a homestay?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body px-0 text-muted small">
                                Simply click the "Book Directly with Host" button on any hotel page. You will be redirected instantly to the hotel's official website or verified Facebook page to finalize your reservation with zero added fees.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed px-0 fw-semibold small" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                How can I list my hotel or homestay?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body px-0 text-muted small">
                                Reach out to us via the contact form above or message us directly on Telegram. Our team will verify your property and set up your photo gallery and booking link.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed px-0 fw-semibold small" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                Can I leave a review without logging in?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body px-0 text-muted small">
                                To protect our hosts and maintain authentic review credibility, you must create a free account or log in before leaving a star rating and review.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
