<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store($username, Request $request)
    {
        $user = User::where('username', $username)->first();
        if (!$user || $user->id == Auth::id()) return redirect('/messages');

        $request->validate([
            'message_content' => 'required'
        ]);
        $request->merge(['to_user_id' => $user->id]);

        Message::create($request->all());
        return redirect()->route('single-msg', $username);
    }

    public function viewAll()
    {
        $messages = Message::orderBy('id', 'DESC')
            ->where('to_user_id', Auth::id())
            ->get()
            ->groupBy('from_user_id');

        return view('messages.viewAll', [
            'messages' => $messages
        ]);
    }

    public function viewSingle($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user || $user->id == Auth::id()) return redirect('/messages');

        $messages = Message::orderBy('id', 'ASC')
            ->whereIn('to_user_id', [Auth::id(), $user->id])
            ->whereIn('from_user_id', [Auth::id(), $user->id])
            ->get();

        return view('messages.viewSingle', [
            'messages' => $messages,
            'username' => $username
        ]);
    }
}
