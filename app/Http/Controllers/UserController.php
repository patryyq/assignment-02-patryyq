<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Follower;

class UserController extends Controller
{
    public function listOfFollowedUserIds()
    {
        return Follower::where('user_id', Auth::id())->pluck('followed_user_id');
    }

    public function explore()
    {
        if (Auth::check()) {
            $followedUsers = $this->listOfFollowedUserIds();
            $users = User::inRandomOrder()
                ->whereNotIn('id', $followedUsers)
                ->limit(20)
                ->get();
        } else {
            $users = User::inRandomOrder()
                ->limit(20)->get();
        }
        return view('explore', [
            'users' => $users
        ]);
    }

    public function findMatchingUsernames($needle)
    {
        $matchingUsernames = User::select('username')->where('username', 'like', '%' . $needle . '%')
            ->where('username', '!=', Auth::user()->username)
            ->get();
        if ($matchingUsernames) {
            return response($matchingUsernames, 200);;
        } else {
            return response('', 401);
        }
    }
}
