@extends('layouts.admin')
@section('title', 'Manage Homestays')
@section('content')
<div class="admin-page-head"><div><h1>Manage Homestays</h1><p>View, edit, and remove homestay listings.</p></div><span class="admin-badge badge-blue">{{ $homestays->total() }} listings</span></div>
<div class="admin-card"><div class="admin-card-header"><h2>All Homestays</h2></div><div class="table-responsive"><table class="admin-table"><thead><tr><th>Homestay</th><th>Host</th><th>Province</th><th>Price / night</th><th>Rating</th><th class="text-end">Action</th></tr></thead><tbody>
@forelse($homestays as $hotel)<tr><td><strong>{{ $hotel->name }}</strong><div class="admin-muted" style="font-size:12px">{{ $hotel->address ?: 'No address' }}</div></td><td>{{ $hotel->host_name ?: 'Unknown' }}</td><td>{{ $hotel->province_name ?: '—' }}</td><td>${{ number_format($hotel->price_per_night,2) }}</td><td>{{ $hotel->star_rating ? $hotel->star_rating . '/5' : '—' }}</td><td class="text-end"><div class="d-inline-flex gap-2"><a class="admin-btn admin-btn-light" href="{{ route('admin.homestays.edit',$hotel->id) }}"><i class="ti ti-edit"></i> Edit</a><form action="{{ route('admin.homestays.destroy',$hotel->id) }}" method="POST" onsubmit="return confirm('Delete this homestay? Its reviews and images may also be removed.')">@csrf @method('DELETE')<button class="admin-btn admin-btn-danger" type="submit"><i class="ti ti-trash"></i> Delete</button></form></div></td></tr>
@empty<tr><td colspan="6"><div class="admin-empty"><i class="ti ti-building-off"></i>No homestays found.</div></td></tr>@endforelse
</tbody></table></div>@if($homestays->hasPages())<div class="admin-pagination">{{ $homestays->links() }}</div>@endif</div>
@endsection
