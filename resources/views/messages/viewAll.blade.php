@extends('layouts.app')
@section('title', 'Direct Messages')
@section('content')

<div class="mt-4">
    @foreach ($messages as $message)
    <div class="my-2 border d-flex flex-row col-12 bg-light justify-content-between align-items-center px-3">
        <div class="p-3">
            @if ($message->from_user_id != Auth::id())
            @if ($message->read == 0)
            <b>
                @endif
                <a href="/messages/{{ $message->from_user->username }}">
                    @else
                    <a href="/messages/{{ $message->to_user->username }}">
                        @endif

                        @if (strlen($message->message_content) >= 45)
                        {{ substr($message->message_content, 0, 45) . '...' }}
                        @else
                        {{$message->message_content}}
                        @endif
                    </a>, {{$message->created_at->diffForHumans()}}
                    @if ($message->from_user_id != Auth::id() && $message->read == 0)
            </b>
            @endif
        </div>
        <h5 class="m-0 p-0">
            &#64;
            @if ($message->from_user_id != Auth::id())
            <a href="/user/{{ $message->from_user->username }}">
                {{ $message->from_user->username }}
                @else
                <a href="/user/{{ $message->to_user->username }}">
                    {{ $message->to_user->username }}
                    @endif
                </a>
        </h5>
    </div>
    @endforeach
</div>
@endsection