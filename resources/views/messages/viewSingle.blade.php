@extends('layouts.app')
@section('title', 'Messages')
@section('content')

<div class="mt-4 col-12 border">
    @foreach ($messages as $message)
    @if ($message->from_user_id === Auth::id())
    <div class="m-3 col-8 float_right">
        <div>
            <b>Me</b>, {{$message->message_sent_at->diffForHumans()}}
        </div>
        <div class="bg-primary p-3">
            {{$message->message_content}}
        </div>
    </div>
    @else
    <div class="m-3 col-8 float_left">
        <div>
            <b>{{$message->from_user->username}}</b>, {{$message->message_sent_at->diffForHumans()}}
        </div>
        <div class="bg-light p-3">
            {{$message->message_content}}
        </div>
    </div>
    @endif
    @endforeach
    <div style="clear:both"></div>
    <form action="{{route('send-msg', $username)}}" method="POST" class="col-12 p-3 d-flex justify-content-between">
        @csrf
        <input type="text" name="message_content" id="message_content" placeholder="Type message here..." class="col-9 p-2">
        <button type="submit" class="col-2 p-2 btn btn-primary">Send message</button>
    </form>
</div>
@endsection