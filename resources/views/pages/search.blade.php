@extends('layouts.app')

@section('title', 'Search Hotels')

@push('styles')
<style>
    .filter-card {
        background: #ffffff;
        border-radius: var(--radius-md);
        border: 1px solid var(--card-border);
        box-shadow: var(--shadow-subtle);
        position: sticky;
        top: 80px;
        overflow: hidden;
    }

    .filter-card-header {
        background: linear-gradient(135deg, var(--primary), #156d56);
        color: #fff;
        padding: 14px 18px;
        font-weight: 600;
        font-family: var(--font-heading);
    }

    .filter-card-body {
        padding: 18px;
    }

    .review-stars { color: #f59e0b; }
</style>
@endpush

@section('content')
<div class="container py-4">

    {{-- Page heading --}}
    <div class="mb-4">
        <h2 style="font-family:var(--font-heading);font-weight:800;color:var(--dark)">
            Search Hotels
        </h2>
        <p class="text-muted">
            @if(request('name'))
                Results for <strong>"{{ request('name') }}"</strong> —
            @endif
            {{ $hotels->total() }} hotel(s) found
        </p>
    </div>

    <div class="row g-4">

        {{-- ── Filter Sidebar ───────────────────────────────────────────── --}}
        <div class="col-lg-3">
            <div class="filter-card">
                <div class="filter-card-header">
                    <i class="bi bi-funnel-fill me-2"></i> Filters
                </div>
                <div class="filter-card-body">
                    <form action="{{ route('hotels.index') }}" method="GET">

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Hotel Name</label>
                            <input type="text" name="name"
                                class="form-control form-control-sm"
                                placeholder="Search by name..."
                                value="{{ request('name') }}"
                                style="border-radius:var(--radius-sm)">
                        </div>

                        {{-- Province --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Province</label>
                            <select name="province_id"
                                class="form-select form-select-sm"
                                style="border-radius:var(--radius-sm)">
                                <option value="">All Provinces</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Price Range --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Price Range ($/night)</label>
                            <div class="row g-1">
                                <div class="col-6">
                                    <input type="number" name="min_price"
                                        class="form-control form-control-sm"
                                        placeholder="Min" min="0"
                                        value="{{ request('min_price') }}"
                                        style="border-radius:var(--radius-sm)">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price"
                                        class="form-control form-control-sm"
                                        placeholder="Max" min="0"
                                        value="{{ request('max_price') }}"
                                        style="border-radius:var(--radius-sm)">
                                </div>
                            </div>
                        </div>

                        {{-- Amenities --}}
                        @if($amenities->isNotEmpty())
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Amenities</label>
                            @foreach ($amenities as $amenity)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="amenities[]"
                                        value="{{ $amenity->id }}"
                                        id="amenity_{{ $amenity->id }}"
                                        {{ in_array($amenity->id, request('amenities', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="amenity_{{ $amenity->id }}">
                                        {{ $amenity->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary-custom btn-sm">
                                <i class="bi bi-search me-1"></i> Apply Filters
                            </button>
                            <a href="{{ route('hotels.index') }}"
                               class="btn btn-outline-secondary btn-sm"
                               style="border-radius:var(--radius-sm)">
                                <i class="bi bi-x-circle me-1"></i> Reset
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- ── Hotel Results Grid ───────────────────────────────────────── --}}
        <div class="col-lg-9">
            <div class="row g-3">
                @forelse ($hotels as $hotel)
                    <div class="col-md-6 col-xl-4">
                        <div class="hotel-card">
                            {{-- Image --}}
                            <div class="hotel-card-img-wrapper">
                                @if ($hotel->images->isNotEmpty())
                                    <img class="hotel-card-img"
                                         src="{{ asset('storage/' . $hotel->images->first()->image_path) }}"
                                         alt="{{ $hotel->name }}">
                                @else
                                    <img class="hotel-card-img"
                                         src="https://placehold.co/400x220?text=No+Image"
                                         alt="No image">
                                @endif

                                <span class="hotel-price-badge">
                                    ${{ number_format($hotel->price_per_night, 0) }}/night
                                </span>
                            </div>

                            {{-- Body --}}
                            <div class="hotel-card-body">
                                <h6 class="fw-bold mb-1" style="font-family:var(--font-heading)">
                                    {{ $hotel->name }}
                                </h6>

                                <p class="text-muted small mb-1">
                                    <i class="bi bi-geo-alt-fill me-1" style="color:var(--primary)"></i>
                                    {{ $hotel->province->name ?? 'Unknown' }}
                                </p>

                                {{-- Review stars --}}
                                @php $avg = $hotel->reviews->avg('rating') ?? 0; @endphp
                                <div class="review-stars small mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= round($avg) ? '-fill' : '' }}"></i>
                                    @endfor
                                    <span class="text-muted ms-1 small">
                                        ({{ $hotel->reviews->count() }})
                                    </span>
                                </div>

                                <div class="mt-auto">
                                    <a href="{{ route('hotels.show', $hotel->id) }}"
                                       class="btn btn-primary-custom btn-sm w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-building fs-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">No hotels found</h5>
                        <p class="text-muted">Try adjusting your filters.</p>
                        <a href="{{ route('hotels.index') }}" class="btn btn-primary-custom">
                            Clear Filters
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($hotels->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $hotels->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
