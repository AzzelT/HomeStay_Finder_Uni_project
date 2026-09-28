@extends('layouts.admin')

@section('title', 'Manage Reviews')

@section('content')

<div class="admin-page-head">

```
<div>
    <h1>Manage Reviews</h1>
    <p>Review and moderate guest feedback.</p>
</div>

<span class="admin-badge badge-blue">
    {{ $reviews->total() }} total reviews
</span>
```

</div>

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
    <h2>All Reviews</h2>
</div>

<div class="table-responsive">

    <table class="admin-table">

        <thead>
            <tr>
                <th>#</th>
                <th>Guest</th>
                <th>Homestay</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($reviews as $review)

                <tr>

                    <td>
                        {{ $review->id }}
                    </td>

                    <td>
                        <strong>
                            {{ $review->user_name }}
                        </strong>
                    </td>

                    <td>
                        {{ $review->hotel_name }}
                    </td>

                    <td>

                        <span class="admin-badge badge-gold">

                            <i class="bi bi-star-fill"></i>

                            {{ $review->rating }}/5

                        </span>

                    </td>

                    <td style="min-width:220px">

                        {{ $review->comment ?: 'No comment' }}

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}

                    </td>

                    <td class="text-end">

                        <div class="d-inline-flex gap-2">

                            {{-- Edit --}}

                            <a href="{{ route('admin.reviews.edit', $review->id) }}"
                               class="admin-btn admin-btn-light">

                                <i class="bi bi-pencil"></i>

                                Edit

                            </a>

                            {{-- Delete --}}

                            <form action="{{ route('admin.reviews.destroy', $review->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this review?')">

                                @csrf
                                @method('DELETE')

                                <button class="admin-btn admin-btn-danger"
                                        type="submit">

                                    <i class="bi bi-trash"></i>

                                    Delete

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7">

                        <div class="admin-empty">

                            <i class="bi bi-chat-square-text"></i>

                            No reviews found.

                        </div>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@if ($reviews->hasPages())

    <div class="admin-pagination">

        {{ $reviews->links() }}

    </div>

@endif

</div>

@endsection
