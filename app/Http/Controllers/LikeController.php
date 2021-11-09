<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $post->id)->get();
        if (isset($like[0]->id)) {
            Like::destroy($like[0]->id);
            return response('', 202);
        } else {
            Like::create(['post_id' => $post->id]);
            return response('', 201);
        }
    }
}
