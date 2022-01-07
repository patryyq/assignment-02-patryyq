@extends('layouts.app')
@section('title', 'Direct Messages')
@section('content')

<div class="mt-4 position-relative">
    <button type="button" data-bs-toggle="modal" data-bs-target="#newMessageModal" class="mt-2 p-2 btn btn-primary position-absolute" id="new-msg" style="right:0;">New message</button>
    @foreach ($messages as $message)
    <div class="my-2 border d-flex flex-row col-12 bg-light justify-content-between align-items-center px-3" style="font-size:0.9rem">
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
        <h5 class="m-0 p-0" style="font-size:0.9rem">
            @if ($message->from_user_id != Auth::id())
            <a href="/user/{{ $message->from_user->username }}" style="font-size:1rem">
                {{ $message->from_user->username }}
                @else
                <a href="/user/{{ $message->to_user->username }}" style="font-size:1rem">
                    {{ $message->to_user->username }}
                    @endif
                </a>
        </h5>
    </div>
    @endforeach

</div>
<!-- Modal -->
<div class="modal fade" id="newMessageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping">TO:</span>
                    <input type="text" id="needle" name="needle" class="form-control" autocomplete="off" placeholder="Start typing username..." aria-label="Username" aria-describedby="addon-wrapping">
                </div>
                <div id="usernamesResp" class="mt-3" style="max-height:70vh;overflow:auto">

                </div>

            </div>
        </div>
    </div>
    <script src="/js/viewAllMessages.js"></script>
    @endsection