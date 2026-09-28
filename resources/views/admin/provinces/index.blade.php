@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Provinces</h2>
        <a href="{{ route('provinces.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Add New Province
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Provinces Table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Existing Provinces</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 10%;">#</th>
                        <th style="width: 60%;">Province Name</th>
                        <th style="width: 30%;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($provinces as $index => $province)
                        <tr>
                            <td>{{ $provinces->firstItem() + $index }}</td>
                            <td class="fw-bold">{{ $province->name }}</td>
                            <td class="text-end">
                                <a href="{{ route('provinces.edit', $province->id) }}" class="btn btn-sm btn-warning me-1">
                                    Edit
                                </a>

                                <form action="{{ route('provinces.destroy', $province->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this province?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">
                                No provinces found. Click "Add New Province" to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination Links --}}
            <div class="mt-3">
                {{ $provinces->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
