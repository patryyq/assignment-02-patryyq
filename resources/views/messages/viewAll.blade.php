@extends('layouts.app')
@section('title', 'Messages')
@section('content')

@foreach ($messages as $message)
<div class="d-flex flex-row col-md-12 bg-light justify-content-between align-items-center px-3">
    <div class="p-3">
        <a href="/messages/{{ $message[0]->from_user->username }}">
            @if (strlen($message[0]->message_content) >= 45)
            {{ substr($message[0]->message_content, 0, 45) . '...' }}
            @else
            {{$message[0]->message_content}}
            @endif
        </a>
    </div>
    <h5 class="m-0 p-0">&#64;<a href="/user/{{ $message[0]->from_user->username }}">{{ $message[0]->from_user->username }}</a>
    </h5>
</div>
@endforeach

@endsection