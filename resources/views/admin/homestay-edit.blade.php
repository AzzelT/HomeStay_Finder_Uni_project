@extends('layouts.admin')

@section('title', 'Edit Homestay')

@section('content')

<div class="admin-page-head">

    <div>
        <h1>Edit Homestay</h1>
        <p>Update the listing information.</p>
    </div>

    <a class="admin-btn admin-btn-light"
        href="{{ route('admin.homestays') }}">
        ←
        Back
    </a>

</div>


<div class="admin-card">

    <div class="admin-card-body">

        <form method="POST"
            action="{{ route('admin.homestays.update', $homestay->id) }}">

            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- Name --}}
                <div class="col-md-6">

                    <label class="admin-form-label">
                        Name
                    </label>

                    <input
                        class="admin-form-control"
                        name="name"
                        value="{{ old('name', $homestay->name) }}"
                        required>

                </div>


                {{-- Province --}}
                <div class="col-md-6">

                    <label class="admin-form-label">
                        Province
                    </label>

                    <select
                        class="admin-form-control"
                        name="province_id"
                        required>

                        @foreach($provinces as $province)

                            <option
                                value="{{ $province->id }}"
                                @selected($province->id == $homestay->province_id)>

                                {{ $province->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Price --}}
                <div class="col-md-6">

                    <label class="admin-form-label">
                        Price per night
                    </label>

                    <input
                        class="admin-form-control"
                        type="number"
                        min="0"
                        step="0.01"
                        name="price_per_night"
                        value="{{ old('price_per_night', $homestay->price_per_night) }}"
                        required>

                </div>


                {{-- Address --}}
                <div class="col-12">

                    <label class="admin-form-label">
                        Address
                    </label>

                    <input
                        class="admin-form-control"
                        name="address"
                        value="{{ old('address', $homestay->address) }}">

                </div>


                {{-- Description --}}
                <div class="col-12">

                    <label class="admin-form-label">
                        Description
                    </label>

                    <textarea
                        class="admin-form-control"
                        name="description"
                        rows="5">{{ old('description', $homestay->description) }}</textarea>

                </div>


                {{-- Amenities --}}
                <div class="col-12">

                    <label class="admin-form-label">
                        Amenities
                    </label>

                    @if ($amenities->count())

                        <div class="row g-3 mt-1">

                            @foreach ($amenities as $amenity)

                                <div class="col-md-4 col-sm-6">

                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="amenities[]"
                                            value="{{ $amenity->id }}"
                                            id="amenity{{ $amenity->id }}"
                                            {{ in_array($amenity->id, old('amenities', $selectedAmenities)) ? 'checked' : '' }}>

                                        <label
                                            class="form-check-label"
                                            for="amenity{{ $amenity->id }}">

                                            {{ $amenity->name }}

                                        </label>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="alert alert-info mt-2 mb-0">
                            No amenities available yet.
                            Please add amenities from
                            <strong>Manage Amenities</strong>.
                        </div>

                    @endif

                </div>


                {{-- Buttons --}}
                <div class="col-12 d-flex justify-content-end gap-2">

                    <a
                        class="admin-btn admin-btn-light"
                        href="{{ route('admin.homestays') }}">

                        Cancel

                    </a>

                    <button
                        class="admin-btn admin-btn-primary"
                        type="submit">

                        Save Changes

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection