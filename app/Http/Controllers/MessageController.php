<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\RealTimeNotification;

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
        $status = 'store';

        $message = Message::create($request->all());
        $data = [$request->message_content, $message->from_user->username];
        $user->notify(new RealTimeNotification($status, $data));

        return redirect()->route('single-msg', $username);
    }

    public function markAsReadJS($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user || $user->id == Auth::id()) return redirect('/messages');

        $messages = Message::where('from_user_id', $user->id)->where('to_user_id', Auth::id())->where('read', 0)->get();
        $this->markAsRead($messages, $username);
        return response('', 202);
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

        $this->markAsRead($messages, $username);

        return view('messages.viewSingle', [
            'messages' => $messages,
            'username' => $username
        ]);
    }

    public function markAsRead($messages, $username)
    {
        $notOwnMessages = $messages->filter(function ($msg) {
            if ($msg->from_user_id != Auth::id() && $msg->read === 0) return $msg;
        });

        foreach ($notOwnMessages as $n) {
            $n->update(['read' => 1]);
        }

        if(!count($notOwnMessages) > 0) return;
        
        $status = 'read';
        $data = ['', $username];

        $user = User::where('username', $username)->first();
        $user->notify(new RealTimeNotification($status, $data));
    }
}
