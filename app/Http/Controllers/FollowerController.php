<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Follower;

class FollowerController extends Controller
{
    public function follow(User $user)
    {
        $following = Follower::where('user_id', '=', Auth::id())->where('followed_user_id', '=', $user->id)->get();
        if (isset($following[0]->id)) {
            Follower::destroy($following[0]->id);
            return response('', 202);
        } else {
            Follower::create(['followed_user_id' => $user->id]);
            return response('', 201);
        }
    }
}
