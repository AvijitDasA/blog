@extends('layouts.app')
@section('title', 'Edit Post')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-warning text-white">Edit Post</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('posts.update', $post->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Title</label>
                            <input type="text" name="title" id="title"
                                   class="form-control"
                                   value="{{ old('title', $post->title) }}" required>
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label for="content" class="form-label fw-bold">Content</label>
                            <textarea name="content" id="content" rows="8"
                                      class="form-control" required>{{ old('content', $post->content) }}</textarea>
                        </div>

                        <!-- Buttons -->
                        <button type="submit" class="btn btn-primary">Update Post</button>
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#content')).catch(console.error);
</script>
@endsection
