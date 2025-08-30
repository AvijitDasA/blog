@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">All Posts (Admin)</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">Back to Dashboard</a>
    </div>

    @php
        $posts = $posts ?? \App\Models\Post::withTrashed()->with('author')->latest()->paginate(20);
    @endphp

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width:60px">#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="width:280px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $loop->iteration + ($posts->currentPage()-1) * $posts->perPage() }}</td>
                            <td>{{ Str::limit($post->title, 60) }}</td>
                            <td>{{ optional($post->author)->name ?? '—' }}</td>
                            <td>
                                @if($post->trashed())
                                    <span class="badge bg-danger">Trashed</span>
                                @else
                                    <span class="badge bg-success">Published</span>
                                @endif
                            </td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary" target="_blank">View</a>

                                @if(! $post->trashed())
                                    <!-- <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning">Edit</a> -->

                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Move post to trash?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Trash</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Restore this post?')">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success">Restore</button>
                                    </form>

                                    <form action="{{ route('admin.posts.force', $post->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Permanently delete this post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete Permanently</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
