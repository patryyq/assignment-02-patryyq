<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function explore()
    {
        if (Auth::check()) {
            $users = User::inRandomOrder()->with('followed')
                ->limit(20)->get();
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
}
