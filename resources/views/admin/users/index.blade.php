@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Users</h1>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">Back to Dashboard</a>
            @can('user Create')
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary ms-2">Create User</a>
            @endcan
        </div>
    </div>


    @php
        // fallback if controller didn't pass $users
        $users = $users ?? \App\Models\User::with('roles')->latest()->paginate(20);
    @endphp

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width:60px">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Joined</th>
                        <th style="width:220px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage()-1) * $users->perPage() }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()->join(', ') ?: '—' }}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="text-nowrap">
                                @can('user Edit')
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                @endcan
                                @can('user Delete')
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete user? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
