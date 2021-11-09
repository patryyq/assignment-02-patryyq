<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index()
    {
        $title = 'Latest posts';
        (Auth::check()) ?
            $usersToDisplayInFeed = Follower::where('user_id', '=', Auth::id())->get('followed_user_id') :
            $usersToDisplayInFeed = Follower::get('followed_user_id');

        $posts = Post::orderBy('posts.id', 'desc')
            ->with(['like' => function ($like) {
                $like->where('user_id', '=', Auth::id());
            }])
            ->whereIn('user_id', $usersToDisplayInFeed)
            ->withCount(['like'])
            ->paginate(10);

        return view('posts.main', [
            'posts' => $posts,
            'title' => $title
        ]);
    }

    public function userPosts($nickname = null)
    {
        $usr = User::where('nickname', '=', $nickname)->first() ?? false;
        if (!$usr) return redirect('/');

        $following = Follower::where('user_id', '=', Auth::id())->where('followed_user_id', '=', $usr->id)->first() ?? false;
        $posts = Post::orderBy('posts.id', 'desc')
            ->with(['like' => function ($like) {
                $like->where('user_id', '=', Auth::id());
            }])
            ->where('user_id', '=', $usr->id)
            ->withCount(['like'])
            ->paginate(10);

        return view('posts.main', [
            'posts' => $posts,
            'title' => $nickname,
            'user' => $usr,
            'following' => $following
        ]);
    }
    public function show(Post $post)
    {
        $post->with(['like' => function ($like) {
            $like->where('user_id', '=', Auth::id());
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
        return redirect('/post/' . strval($post->id));
        //    ->with('success', 'msg');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        $userNickname = $post->user->nickname;
        $post->delete();

        return redirect('/user/' . $userNickname);
        //    ->with('success', 'msg');
    }


    public function update(Request $request, Post $post)
    {
        $request->validate([
            'post_content' => 'required'
        ]);

        $post->update($request->all());
        return redirect('/post/' . strval($post->id));
        //     ->with('success', 'msg');
    }
}
