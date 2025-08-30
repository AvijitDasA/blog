@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Post details --}}
    <div class="card shadow-sm border-0 rounded-lg mb-4">
        <div class="card-body">
            <h2 class="card-title mb-2">{{ $post->title }}</h2>
            <p class="text-muted small mb-3">
                By <strong>{{ $post->author->name }}</strong> • {{ $post->created_at->format('M d, Y') }}
            </p>
            <div class="mb-3">{!! $post->content !!}</div>

            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this post?')">Delete</button>
                </form>
            @endcan
        </div>
    </div>

    {{-- Comments --}}
    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-light">
            Comments ({{ $post->comments->count() }})
        </div>
        <div class="card-body">
            @forelse($post->comments as $comment)
                <div class="border-bottom pb-2 mb-2">
                    <strong>{{ $comment->author->name }}</strong>
                    <span class="text-muted small"> • {{ $comment->created_at->diffForHumans() }}</span>
                    <p class="mb-1">{{ $comment->body }}</p>
                    @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-link text-danger p-0">Delete</button>
                        </form>
                    @endcan
                </div>
            @empty
                <p class="text-muted">No comments yet.</p>
            @endforelse
        </div>

        {{-- Comment form --}}
        @auth
            <div class="card-footer">
                <form action="{{ route('comments.store', $post) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <textarea name="body" rows="3" class="form-control"
                                  placeholder="Write a comment..." required></textarea>
                    </div>
                    <button class="btn btn-primary btn-sm" type="submit" >Post Comment</button>
                </form>
            </div>
        @endauth
    </div>
</div>
@endsection
