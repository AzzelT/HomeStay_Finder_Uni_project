@extends('layouts.admin')
@section('title', 'Edit Homestay')
@section('content')
<div class="admin-page-head"><div><h1>Edit Homestay</h1><p>Update the listing information.</p></div><a class="admin-btn admin-btn-light" href="{{ route('admin.homestays') }}"><i class="ti ti-arrow-left"></i> Back</a></div>
<div class="admin-card"><div class="admin-card-body"><form method="POST" action="{{ route('admin.homestays.update',$homestay->id) }}">@csrf @method('PUT')<div class="row g-3">
<div class="col-md-6"><label class="admin-form-label">Name</label><input class="admin-form-control" name="name" value="{{ old('name',$homestay->name) }}" required></div>
<div class="col-md-6"><label class="admin-form-label">Province</label><select class="admin-form-control" name="province_id" required>@foreach($provinces as $province)<option value="{{ $province->id }}" @selected($province->id == $homestay->province_id)>{{ $province->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="admin-form-label">Price per night</label><input class="admin-form-control" type="number" min="0" step="0.01" name="price_per_night" value="{{ old('price_per_night',$homestay->price_per_night) }}" required></div>
<div class="col-md-6"><label class="admin-form-label">Star rating</label><select class="admin-form-control" name="star_rating"><option value="">Not rated</option>@for($i=1;$i<=5;$i++)<option value="{{ $i }}" @selected($i == $homestay->star_rating)>{{ $i }} / 5</option>@endfor</select></div>
<div class="col-12"><label class="admin-form-label">Address</label><input class="admin-form-control" name="address" value="{{ old('address',$homestay->address) }}"></div>
<div class="col-12"><label class="admin-form-label">Description</label><textarea class="admin-form-control" name="description" rows="5">{{ old('description',$homestay->description) }}</textarea></div>
<div class="col-12 d-flex justify-content-end gap-2"><a class="admin-btn admin-btn-light" href="{{ route('admin.homestays') }}">Cancel</a><button class="admin-btn admin-btn-primary" type="submit"><i class="ti ti-device-floppy"></i> Save Changes</button></div>
</div></form></div></div>
@endsection
