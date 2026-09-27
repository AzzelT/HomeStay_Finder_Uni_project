@extends('layouts.admin')
@section('title', 'Manage Reviews')
@section('content')
<div class="admin-page-head"><div><h1>Manage Reviews</h1><p>Review and moderate guest feedback.</p></div><span class="admin-badge badge-blue">{{ $reviews->total() }} total reviews</span></div>
<div class="admin-card">
    <div class="admin-card-header"><h2>All Reviews</h2></div>
    <div class="table-responsive"><table class="admin-table"><thead><tr><th>#</th><th>Guest</th><th>Homestay</th><th>Rating</th><th>Comment</th><th>Date</th><th class="text-end">Action</th></tr></thead><tbody>
    @forelse($reviews as $review)<tr><td>{{ $review->id }}</td><td><strong>{{ $review->user_name }}</strong></td><td>{{ $review->hotel_name }}</td><td><span class="admin-badge badge-yellow"><i class="ti ti-star-filled"></i>{{ $review->rating }}/5</span></td><td style="min-width:220px">{{ $review->comment ?: 'No comment' }}</td><td>{{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}</td><td class="text-end"><form action="{{ route('admin.reviews.destroy',$review->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">@csrf @method('DELETE')<button class="admin-btn admin-btn-danger" type="submit"><i class="ti ti-trash"></i> Delete</button></form></td></tr>
    @empty<tr><td colspan="7"><div class="admin-empty"><i class="ti ti-message-off"></i>No reviews found.</div></td></tr>@endforelse
    </tbody></table></div>
    @if($reviews->hasPages())<div class="admin-pagination">{{ $reviews->links() }}</div>@endif
</div>
@endsection
