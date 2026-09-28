@extends('layouts.admin')

@section('title', 'Add Homestay')

@section('content')

    <div class="admin-page-head">

        <div>
            <h1>Add Homestay</h1>
            <p>Create a new homestay listing.</p>
        </div>

        <a href="{{ route('admin.homestays') }}" class="admin-btn admin-btn-light">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following:</strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="admin-card">

        <div class="admin-card-header">
            <h2>Homestay Information</h2>
        </div>


        <div class="p-4">

            <form action="{{ route('admin.homestays.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="row g-4">

                    {{-- Image --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Homestay Image
                        </label>

                        <input type="file" name="image" class="form-control"
                            accept="image/jpeg,image/png,image/jpg,image/webp" required>

                        <div class="form-text">
                            JPG, PNG or WebP. Maximum 5MB.
                        </div>

                    </div>


                    {{-- Name --}}
                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Homestay Name
                        </label>

                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                            placeholder="Enter homestay name" required>

                    </div>


                    {{-- Price --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Price Per Night
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                $
                            </span>

                            <input type="number" name="price_per_night" class="form-control"
                                value="{{ old('price_per_night') }}" min="0" step="0.01" placeholder="0.00"
                                required>

                        </div>

                    </div>


                    {{-- Province --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Province
                        </label>

                        <select name="province_id" class="form-select" required>

                            <option value="">
                                Select province
                            </option>

                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}"
                                    {{ old('province_id') == $province->id ? 'selected' : '' }}>

                                    {{ $province->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Host --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Host
                        </label>

                        <select name="user_id" class="form-select" required>

                            <option value="">
                                Select host
                            </option>

                            @foreach ($hosts as $host)
                                <option value="{{ $host->id }}" {{ old('user_id') == $host->id ? 'selected' : '' }}>

                                    {{ $host->name }} ({{ $host->email }})

                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Address --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Address
                        </label>

                        <input type="text" name="address" class="form-control" value="{{ old('address') }}"
                            placeholder="Enter address">

                    </div>


                    {{-- Description --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Description
                        </label>

                        <textarea name="description" class="form-control" rows="5" placeholder="Describe the homestay...">{{ old('description') }}</textarea>

                    </div>


                    {{-- Amenities --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Amenities
                        </label>

                        @if ($amenities->count())

                            <div class="row g-3">

                                @foreach ($amenities as $amenity)
                                    <div class="col-md-4 col-sm-6">

                                        <div class="form-check">

                                            <input class="form-check-input" type="checkbox" name="amenities[]"
                                                value="{{ $amenity->id }}" id="amenity{{ $amenity->id }}"
                                                {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }}>

                                            <label class="form-check-label" for="amenity{{ $amenity->id }}">

                                                {{ $amenity->name }}

                                            </label>

                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                No amenities available yet.
                                Please add amenities from
                                <strong>Manage Amenities</strong>.
                            </div>

                        @endif

                    </div>


                    {{-- Website --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Website URL
                        </label>

                        <input type="url" name="website_url" class="form-control" value="{{ old('website_url') }}"
                            placeholder="https://example.com">

                    </div>


                    {{-- Facebook --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Facebook URL
                        </label>

                        <input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url') }}"
                            placeholder="https://facebook.com/...">

                    </div>


                    {{-- Google Maps --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Google Maps URL
                        </label>

                        <input type="url" name="google_maps_url" class="form-control"
                            value="{{ old('google_maps_url') }}" placeholder="https://maps.google.com/...">

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="mt-4 d-flex gap-2">

                    <button type="submit" class="admin-btn admin-btn-primary">

                        <i class="bi bi-plus-lg"></i>

                        Add Homestay

                    </button>


                    <a href="{{ route('admin.homestays') }}" class="admin-btn admin-btn-light">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection
