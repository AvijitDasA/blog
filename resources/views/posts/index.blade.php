@extends('layouts.app')
@section('title', 'All Posts')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">All Posts</h1>
        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-primary">+ New Post</a>
        @endauth
    </div>

    @forelse($posts as $post)
        <div class="card shadow-sm mb-4 border-0 rounded-lg">
            <div class="card-body">
                <h4 class="card-title mb-2">
                    <a href="{{ route('posts.show', $post) }}" class="text-dark text-decoration-none">
                        {{ $post->title }}
                    </a>
                </h4>
                <p class="text-muted small mb-3">
                    By <strong>{{ $post->author->name }}</strong> • {{ $post->created_at->format('M d, Y') }}
                </p>
                <p class="card-text">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary btn-sm">Read More</a>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No posts yet. Be the first to create one!</div>
    @endforelse

    <div class="mt-3">
        {{ $posts->links() }}
    </div>
</div>
@endsection
