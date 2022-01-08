@extends('layouts.app')
@section('title', $title)

@section('content')
    @if (isset($user))
        <div class="p-3 bg-light mb-5"><b>{{ $user->username }}</b> says:<br>
            <blockquote class="blockquote">"{{ $user->description }}"</blockquote>
        </div>
    @endif
    <div class="mt-4">
        @if (session()->has('success'))
            <div class="alert alert-warning" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (Auth::check() && $title == Auth::user()->username)
            <form action="/posts" method="POST">
                @csrf
                <div class="p-4 mb-5 form-group bg-light border">
                    <h3>Add a new public post</h3>
                    <label class="sr-only" for="post_content">Post content:</label>
                    <textarea placeholder="Type something to the world..." name="post_content" id="post_content" row="7"
                        class="form-control form-control-lg my-3 p-2 bg-gray-200 @error('comments') is-invalid @enderror"></textarea>

                    @error('post_content')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="my-2 btn btn-primary">Add post</button>
                </div>
            </form>
        @endif
        @if (count($posts) === 0)
            <h2>No posts to display. Add something.</h2>
        @endif
        @foreach ($posts as $post)
            <div class="mb-5 border">
                <div class="d-flex flex-row col-md-12 bg-info justify-content-between align-items-center px-3">
                    <div class="p-3 align-items-center">
                        <h5 class="m-0 p-0">&#64;
                            <a href="/user/{{ $post->user->username }}">{{ $post->user->username }}</a>,
                            <a href="/post/{{ $post->id }}">{{ $post->created_at->diffForHumans() }}</a>
                        </h5>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="p-3 position-relative">
                            <a href="/post/{{ $post->id }}"><i class="far fa-comment"></i> </a>
                            <span class="position-absolute bottom-0 right-0 translate-middle badge rounded-pill bg-danger">
                                {{ $post->comment->count() }}
                            </span>
                        </div>
                        <div class="p-3 position-relative">
                            @if (isset($post->like[0]))
                                <!-- full heart icon -->
                                <i id="{{ $post->id }}" class="fas fa-heart like @if (Auth::guest())guest @endif"></i>
                            @else
                                <!-- empty heart icon -->
                                <i id="{{ $post->id }}" class="far fa-heart like @if (Auth::guest())guest @endif"></i>
                            @endif
                            <span class="position-absolute bottom-0 right-0 translate-middle badge rounded-pill bg-danger">
                                {{ $post->like_count }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-light">{{ $post->post_content }}</div>
                @if (Auth::check() && ($post->user_id === Auth::id() || Auth::user()->admin_role == 1))
                    <form class="d-flex justify-content-end mt-2" action="{{ route('posts.destroy', $post->id) }}"
                        method="POST">
                        <a class="m-2 btn-outline-primary btn" href="{{ route('posts.edit', $post->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="m-2 btn-outline-danger btn">Delete</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
    <script src="/js/like.js"></script>
    <script src="/js/follower.js"></script>
    {!! $posts->links() !!}
@endsection
