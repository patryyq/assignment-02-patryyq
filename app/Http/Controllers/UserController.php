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
        $followedUsers = $this->listOfFollowedUserIds();
        if (Auth::check()) {
            $users = User::inRandomOrder()
                ->whereNotIn('id', $followedUsers)
                ->with('followed')
                ->limit(20)
                ->get();
            foreach ($users as $user) {
                $user->followedStatus = false;
                foreach ($user->followed as $followed) {
                    if ($followed->user_id == Auth::id()) {
                        $user->followedStatus = true;
                    }
                }
            }
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
