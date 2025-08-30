<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

            $page = request('page', 1); // detect current page

        $posts = Cache::remember("posts_with_comments_page_{$page}", 60, function () {
            return Post::with('author')
                    ->latest()
                    ->paginate(2); // show 5 per page
        });

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // $this->authorize('create', Post::class);
        $data = $request->validated();

        $post = $request->user()->posts()->create($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['author','comments.author']);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'content' => ['required','string'],
        ]);
        $post->update($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete(); // soft delete
        return redirect()->route('posts.index')->with('success', 'Post deleted.');
    }

    /** Admin helpers */
    public function adminIndex()
    {
        $posts = Post::withTrashed()->with('author')->latest()->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('restore', $post);
        $post->restore();
        return back()->with('success','Post restored.');
    }
    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $post);
        $post->forceDelete();
        return back()->with('success','Post permanently deleted.');
    }

}
