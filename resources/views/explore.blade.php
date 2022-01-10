@extends('layouts.app')

@section('title')
    <h2>Explore users</h2>
@endsection
@section('content')

    <div class="mt-4">
        <div class="mb-3">
            <div class="col-12">
                <div id="explore" class="d-flex flex-wrap flex-row align-items-center col-12">
                    @foreach ($users as $user)
                        <div
                            class="position-relative mb-3 border d-flex flex-row justify-content-between align-items-center px-3 col-12">
                            <a href="/user/{{ $user->username }}">{{ $user->username }} </a>
                            <div class="d-flex align-items-center">
                                <div class="p-3 position-relative">
                                    <button id="{{ $user->id }}" type="button"
                                        class="btn btn-outline-dark follow @if (Auth::guest())guest @endif">Follow</button>
                                    <span
                                        class="position-absolute bottom-0 right-0 translate-middle badge rounded-pill bg-danger">
                                        {{ $user->followed->count() }}
                                    </span>
                                </div>
                                <div class="p-3 position-relative">
                                    <a href="/user/{{ $user->username }}"> <i class="far fa-comment-alt"></i></a>
                                    <span
                                        class="position-absolute bottom-0 right-0 translate-middle badge rounded-pill bg-danger">
                                        {{ $user->post->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
            <div class="mb-5">

            </div>
        </div>
        <script src="/../js/follower.js"></script>
    @endsection
