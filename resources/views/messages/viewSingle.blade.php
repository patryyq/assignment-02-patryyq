@extends('layouts.app')
@section('title', 'DM with: ' . $username)

@section('content')
    <div class="mt-4 col-12 border">
        <div id="msg-box" class="pb-5" style="overflow-y:scroll;font-size:0.9rem">
            @if (count($messages) === 0)
                <div class="bg-warning p-3 position-relative my-3 mx-auto col-10 rounded">
                    You have not spoken to this user before. Send your first message now!
                </div>
            @endif
            @foreach ($messages as $message)
                @if ($message->from_user_id === Auth::id())
                    <div class="m-3 col-8 float_right">
                        <div>
                            <b>Me</b>, {{ $message->created_at->diffForHumans() }}
                        </div>
                        <div class="bg-info p-3 position-relative rounded">
                            {{ $message->message_content }}
                            @if ($message->read === 0)
                                <i class="fas fa-check" style="position:absolute;right:10px;bottom:-20px;font-size:1rem"
                                    title="Message unread"></i>
                            @else
                                <i class="fas fa-check-double"
                                    style="position:absolute;right:10px;bottom:-20px;font-size:1rem"
                                    title="Message read"></i>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="m-3 col-8 float_left">
                        <div>
                            <b><a
                                    href="/user/{{ $message->from_user->username }}">{{ $message->from_user->username }}</a></b>,
                            {{ $message->created_at->diffForHumans() }}
                        </div>
                        <div class="bg-light p-3 rounded">
                            {{ $message->message_content }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div style="clear:both"></div>
        <form id="send-msg" action="{{ route('send-msg', $username) }}" method="POST"
            class="col-12 p-3 d-flex justify-content-between bg-light border-top">
            @csrf
            <input type="text" name="message_content" autocomplete="off" id="message_content"
                placeholder="Type message here..." class="col-8 p-2">
            <button type="submit" class="col-3 p-2 btn btn-outline-primary">Send message</button>
        </form>
    </div>
    <script src="/js/messages.js"></script>
@endsection
