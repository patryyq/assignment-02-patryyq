<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('posts.id', 'desc')
            ->with(['user', 'like' => function ($like) {
                $like->where('user_id', '=', Auth::id());
            }])
            ->withCount(['like'])
            ->paginate(10);

        return view('posts.main', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {
        $posts = Post::where('id', '=', $post->id)
            ->with(['user', 'like' => function ($like) {
                $like->where('user_id', '=', Auth::id());
            }])
            ->withCount(['like'])
            ->first();

        return view('posts.show', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_content' => 'required'
        ]);

        Post::create($request->all());

        return redirect('/posts');
        //    ->with('success', 'Signing created successfully.');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/posts')
            ->with('success', 'Signing deleted successfully');
    }


    public function update(Request $request, Post $post)
    {
        $request->validate([
            'post_content' => 'required'
        ]);

        $post->update($request->all());

        return redirect('/posts')
            ->with('success', 'Signing updated successfully');
    }
}
