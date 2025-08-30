@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Admin Dashboard</h1>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">Manage Users</a>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-secondary">Manage Posts</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Users</h6>
                    <p class="display-6 mb-0">{{ \App\Models\User::count() }}</p>
                    <small class="text-muted">Total registered users</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Posts</h6>
                    <p class="display-6 mb-0">{{ \App\Models\Post::count() }}</p>
                    <small class="text-muted">Total posts • Trashed: {{ \App\Models\Post::onlyTrashed()->count() }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Recent</h6>
                    <p class="mb-0">Latest user: {{ optional(\App\Models\User::latest()->first())->name ?? '—' }}</p>
                    <p class="mb-0">Latest post: {{ optional(\App\Models\Post::latest()->first())->title ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
