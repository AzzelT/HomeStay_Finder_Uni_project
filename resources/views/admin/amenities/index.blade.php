@extends('layouts.admin')

@section('title', 'Manage Amenities')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Manage Amenities</h2>

            <p class="text-muted mb-0">
                Add and manage amenities available at homestays.
            </p>
        </div>

        <a href="{{ route('admin.amenities.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg"></i>
            Add Amenity

        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- Amenities Table --}}
    @if($amenities->count())

        <div class="card">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Amenity</th>

                                <th class="text-end">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($amenities as $amenity)

                                <tr>

                                    <td>
                                        {{ $amenities->firstItem() + $loop->index }}
                                    </td>


                                    <td>
                                        <strong>
                                            {{ $amenity->name }}
                                        </strong>
                                    </td>


                                    <td class="text-end">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.amenities.edit', $amenity->id) }}"
                                           class="btn btn-sm btn-outline-primary">

                                            <i class="bi bi-pencil"></i>
                                            Edit

                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('admin.amenities.destroy', $amenity->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Delete this amenity?');">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger">

                                                <i class="bi bi-trash"></i>
                                                Delete

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- Pagination --}}
        @if($amenities->hasPages())

            <div class="d-flex justify-content-between mt-4 mb-4">

                {{ $amenities->links('pagination::bootstrap-5') }}

            </div>

        @endif


    @else

        {{-- Empty State --}}
        <div class="card">

            <div class="card-body text-center py-5">

                <i class="bi bi-list-check fs-1 text-muted"></i>

                <h5 class="mt-3">
                    No amenities yet
                </h5>

                <p class="text-muted">
                    Add your first amenity to use it when creating a homestay.
                </p>

                <a href="{{ route('admin.amenities.create') }}"
                   class="btn btn-primary">

                    Add Amenity

                </a>

            </div>

        </div>

    @endif

</div>

@endsection