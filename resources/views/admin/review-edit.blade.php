@extends('layouts.admin')

@section('title', 'Edit Review')

@section('content')

<div class="admin-page-head">

```
<div>
    <h1>Edit Review</h1>
    <p>Update the guest review.</p>
</div>

<a href="{{ route('admin.reviews') }}"
   class="admin-btn admin-btn-light">

    <i class="bi bi-arrow-left"></i>
    Back to Reviews

</a>
```

</div>

@if ($errors->any())

```
<div class="alert alert-danger">

    <strong>Please fix the following:</strong>

    <ul class="mb-0 mt-2">

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </ul>

</div>
```

@endif

@if (session('success'))

```
<div class="alert alert-success">
    {{ session('success') }}
</div>
```

@endif

<div class="admin-card">

```
<div class="admin-card-header">
    <h2>Review Information</h2>
</div>

<div class="p-4">

    <div class="row g-4 mb-4">

        <div class="col-md-6">

            <div class="text-muted small mb-1">
                Guest
            </div>

            <strong>
                {{ $review->user_name }}
            </strong>

        </div>

        <div class="col-md-6">

            <div class="text-muted small mb-1">
                Homestay
            </div>

            <strong>
                {{ $review->hotel_name }}
            </strong>

        </div>

    </div>

    <form action="{{ route('admin.reviews.update', $review->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-4">

            <label for="rating"
                   class="form-label fw-semibold">

                Rating

            </label>

            <select name="rating"
                    id="rating"
                    class="form-select"
                    required>

                @for ($i = 1; $i <= 5; $i++)

                    <option value="{{ $i }}"
                        {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>

                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}

                    </option>

                @endfor

            </select>

        </div>

        <div class="mb-4">

            <label for="comment"
                   class="form-label fw-semibold">

                Comment

            </label>

            <textarea name="comment"
                      id="comment"
                      class="form-control"
                      rows="6"
                      placeholder="Enter review comment...">{{ old('comment', $review->comment) }}</textarea>

        </div>

        <div class="d-flex gap-2">

            <button type="submit"
                    class="admin-btn admin-btn-primary">

                <i class="bi bi-check-lg"></i>

                Save Changes

            </button>

            <a href="{{ route('admin.reviews') }}"
               class="admin-btn admin-btn-light">

                Cancel

            </a>

        </div>

    </form>

</div>
```

</div>

@endsection
