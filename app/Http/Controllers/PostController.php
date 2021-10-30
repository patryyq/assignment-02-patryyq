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
        $posts = Post::orderBy('created_at', 'desc')->paginate(1);
        return view('po', [
            'posts' => $posts
        ]);
    }

    public function stores()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate();
        return view('po', [
            'posts' => $posts
        ]);
    }
}
