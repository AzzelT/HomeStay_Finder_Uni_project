@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">My Reviews</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($reviews as $review)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="card-title">
                        {{-- Make sure the hotel relationship is loaded in the controller --}}
                        {{ $review->hotel ? $review->hotel->name : 'Unknown Hotel' }}
                    </h5>
                    <span class="badge bg-warning text-dark">
                        {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                    </span>
                </div>

                <p class="card-text mt-2">{{ $review->comment ?? 'No comment provided.' }}</p>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">Reviewed on {{ $review->created_at->format('M d, Y') }}</small>

                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this review?')">
                            Delete Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">You haven't written any reviews yet.</div>
    @endforelse

    {{-- Pagination --}}
    {{ $reviews->links() }}
</div>
@endsection
