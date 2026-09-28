@extends('layouts.admin')

@section('title', 'Edit Amenity')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Edit Amenity</h2>
            <p class="text-muted mb-0">
                Update this amenity.
            </p>
        </div>

        <a href="{{ route('admin.amenities.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.amenities.update', $amenity->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">
                        Amenity Name
                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control"
                           value="{{ old('name', $amenity->name) }}"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Save Changes
                </button>

                <a href="{{ route('admin.amenities.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>
    </div>

</div>

@endsection