<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function isPostOwnerOrAdmin($post)
    {
        return ($post->user_id != Auth::id() && Auth::user()->admin_role != 1) ? false : true;
    }

    public function index()
    {
        $title = "Posts of all users";

        $posts = Post::orderBy('posts.id', 'desc')
            ->with(['like' => function ($like) {
                $like->where('user_id', Auth::id());
            }])
            ->withCount(['like'])
            ->paginate(10);

        return view('posts.main', [
            'posts' => $posts,
            'title' => $title
        ]);
    }

    public function feed()
    {
        $title = 'Posts of followed users';
        $usersToDisplayInFeed = Follower::where('user_id', Auth::id())->get('followed_user_id');

        $posts = Post::orderBy('posts.id', 'desc')
            ->with(['like' => function ($like) {
                $like->where('user_id', Auth::id());
            }])
            ->whereIn('user_id', $usersToDisplayInFeed)
            ->withCount(['like'])
            ->paginate(10);

        return view('posts.main', [
            'posts' => $posts,
            'title' => $title
        ]);
    }

    public function userPosts($username = null)
    {
        $usr = User::where('username', $username)->first() ?? false;
        if (!$usr) return redirect('/');

        $following = Follower::where('user_id', Auth::id())->where('followed_user_id', $usr->id)->first() ?? false;
        $posts = Post::orderBy('posts.id', 'desc')
            ->with(['like' => function ($like) {
                $like->where('user_id', Auth::id());
            }])
            ->where('user_id', $usr->id)
            ->withCount(['like'])
            ->paginate(10);

        return view('posts.main', [
            'posts' => $posts,
            'title' => $username,
            'user' => $usr,
            'following' => $following
        ]);
    }
    public function show(Post $post)
    {
        $post->with(['like' => function ($like) {
            $like->where('user_id', Auth::id());
        }])->first();

        return view('posts.show', [
            'post' => $post
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

        $post = Post::create($request->all());
        return redirect('/post/' . strval($post->id))
            ->with('success', 'Post added successfully.');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        if (!$this->isPostOwnerOrAdmin($post)) return redirect('/');

        $userusername = $post->user->username;
        $post->delete();

        return redirect('/user/' . $userusername)
            ->with('success', 'Post deleted successfully.');
    }


    public function update(Request $request, Post $post)
    {
        if (!$this->isPostOwnerOrAdmin($post)) return redirect('/');

        $request->validate([
            'post_content' => 'required'
        ]);
        $post->update($request->all());

        return redirect('/post/' . strval($post->id))
            ->with('success', 'Post updated successfully.');
    }
}
