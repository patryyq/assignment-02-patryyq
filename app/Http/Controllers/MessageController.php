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
            ->orWhere('from_user_id', Auth::id())
            ->get();

        $messages = $this->filterLastMessages($messages);
        return view('messages.viewAll', [
            'messages' => $messages
        ]);
    }

    public function filterLastMessages($messages)
    {
        // a bit ugly way of doing thigs, but I couldn't filter the collection using eloquent
        $uniqueUserPairs = array();
        $uniqueMessages = array();
        foreach ($messages as $message) {
            $a = $message->from_user_id;
            $b = $message->to_user_id;
            if (!(in_array([$a, $b], $uniqueUserPairs) || in_array([$b, $a], $uniqueUserPairs))) {
                array_push($uniqueMessages, $message);
                array_push($uniqueUserPairs, [$a, $b]);
            }
        }
        return $uniqueMessages;
    }

    public function viewSingle($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user || $user->id == Auth::id()) return redirect('/messages');

        $messages = Message::orderBy('id', 'ASC')
            ->whereIn('to_user_id', [Auth::id(), $user->id])
            ->whereIn('from_user_id', [Auth::id(), $user->id])
            ->get();

        $this->markAsRead($messages);

        return view('messages.viewSingle', [
            'messages' => $messages,
            'username' => $username
        ]);
    }

    public function markAsRead($messages)
    {
        $notOwnMessages = $messages->filter(function ($msg) {
            if ($msg->from_user_id != Auth::id() && $msg->read === 0) return $msg;
        });
        foreach ($notOwnMessages as $n) {
            $n->update(['read' => 1]);
        }
    }
}
