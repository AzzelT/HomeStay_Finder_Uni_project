@extends('layouts.admin')

@section('title', 'Manage Homestays')

@section('content')

<div class="admin-page-head">

    <div>
        <h1>Manage Homestays</h1>
        <p>View, edit, and remove homestay listings.</p>
    </div>

    <div class="d-flex align-items-center gap-2">

        <span class="admin-badge badge-blue">
            {{ $homestays->total() }} listings
        </span>

        <a href="{{ route('admin.homestays.create') }}"
           class="admin-btn admin-btn-primary">

            <i class="bi bi-plus-lg"></i>

            Add Homestay

        </a>

    </div>

</div>


<div class="admin-card">

    <div class="admin-card-header">
        <h2>All Homestays</h2>
    </div>


    <div class="table-responsive">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Homestay</th>
                    <th>Host</th>
                    <th>Province</th>
                    <th>Price / night</th>
                    <th>Rating</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>


            <tbody>

                @forelse($homestays as $hotel)

                    <tr>

                        <td>

                            <strong>
                                {{ $hotel->name }}
                            </strong>

                            <div class="admin-muted"
                                 style="font-size:12px">

                                {{ $hotel->address ?: 'No address' }}

                            </div>

                        </td>


                        <td>
                            {{ $hotel->host_name ?: 'Unknown' }}
                        </td>


                        <td>
                            {{ $hotel->province_name ?: '—' }}
                        </td>


                        <td>
                            ${{ number_format($hotel->price_per_night, 2) }}
                        </td>


                        <td>

                            @if($hotel->star_rating)

                                <span class="admin-badge badge-gold">

                                    <i class="bi bi-star-fill"></i>

                                    {{ $hotel->star_rating }}/5

                                </span>

                            @else

                                —

                            @endif

                        </td>


                        <td class="text-end">

                            <div class="d-inline-flex gap-2">

                                {{-- Edit --}}
                                <a class="admin-btn admin-btn-light"
                                   href="{{ route('admin.homestays.edit', $hotel->id) }}">

                                    <i class="bi bi-pencil"></i>

                                    Edit

                                </a>


                                {{-- Delete --}}
                                <form action="{{ route('admin.homestays.destroy', $hotel->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this homestay? Its reviews and images may also be removed.')">

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

                        <td colspan="6">

                            <div class="admin-empty">

                                <i class="bi bi-house-x"></i>

                                No homestays found.

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    @if ($homestays->hasPages())

        <div class="admin-pagination">

            {{ $homestays->links() }}

        </div>

    @endif

</div>

@endsection