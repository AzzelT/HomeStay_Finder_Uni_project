@extends('layouts.admin')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Manage Users</h1>
            <p>View and manage registered users.</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-body">
            @if ($users->count())
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td>
                                    {{ $user->created_at?->format('d M Y') }}
                                </td>

                                <td>
                                    <form
                                        action="{{ route('admin.users.ban', $user->id) }}"
                                        method="POST"
                                        style="display:inline;"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <button
                                            type="submit"
                                            class="admin-btn admin-btn-warning"
                                        >
                                            Ban User
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('admin.users.destroy', $user->id) }}"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="admin-btn admin-btn-danger"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top: 20px;">
                    {{ $users->links() }}
                </div>
            @else
                <p>No users found.</p>
            @endif
        </div>
    </div>
@endsection