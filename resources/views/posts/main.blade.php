@extends('layouts.app')
@section('title')

    @if (isset($user) && $user != null)
        <div class="d-flex">
            <div class="col-4 position-relative" style="width: 115px;height: 115px">
                <img class="image rounded-circle" src="{{ asset('storage/images/' . $user->avatar_path) }}"
                    alt="profile_image" style="width: 100%;height: 100%">
                @if (Auth::check() && Auth::user()->username === $user->username)
                    <div id="changeProfileImageButton" class="position-absolute" style="right:2px;bottom:2px;cursor:pointer"
                        data-bs-toggle="modal" data-bs-target="#newMessageModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#fff"
                            class="bi bi-person-circle" viewBox="0 0 16 16"
                            style="background: #0d6efd; border-radius: 50rem; border: 3px solid #0d6efd;">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                        </svg>
                    </div>
                @endif
            </div>
            <div class="px-2 col">
                <h2 style="width:fit-content;display: inline;">{{ $user->username }} </h2> says:<br>
                <blockquote>"{{ $user->description }}"</blockquote>
            </div>
        </div>
    @else
        <h2>{{ $title }}</h2>
    @endif

@endsection
@section('content')
    <div class="mt-4">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
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
    @if (Auth::check() && count($posts) === 0 && $page === 'user' && Auth::user()->username === $title)
        <h2>No posts to display. Write your first post!</h2>
    @elseif (Auth::check() && count($posts) === 0 && $page === 'user' && Auth::user()->username != $title)
        <h2>No posts to display. This user has not written any post yet.</h2>
    @elseif (count($posts) === 0 && $page === 'main')
        <h2>No posts in DB. Run migrations</h2>
    @elseif (count($posts) === 0 && $page === 'feed')
        <h3>No posts to display. <a href="/explore" class="link-primary">Explore</a> users and follow someone (even
            yourself).</h3>
    @endif
    @foreach ($posts as $post)
        <div class="mb-5 border">
            <div class="d-flex flex-row col-md-12 bg-info justify-content-between align-items-center px-3">
                <div class="p-3 align-items-center">
                    <h5 class="m-0 p-0 text-white">&#64;<b>
                            <a class="text-white"
                                href="/user/{{ $post->user->username }}">{{ $post->user->username }}</a>,
                            <a class="text-white"
                                href="/post/{{ $post->id }}">{{ $post->created_at->diffForHumans(null, true) }}</a></b>
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
    @if (Auth::check() && isset($user) && Auth::user()->username === $user->username)
        <div class="modal fade" id="newMessageModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change profile image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Select a new image and then hit the upload button.
                        <form action="{{ route('upload-image') }}" method="POST" enctype="multipart/form-data"
                            class="mt-3">
                            @csrf
                            <div class="input-group">
                                <input type="file" class="form-control" id="inputGroupFile04"
                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image">
                                <button class="btn btn-outline-secondary" type="submit"
                                    id="inputGroupFileAddon04">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script src="/js/like.js"></script>
    <script src="/js/follower.js"></script>
    {!! $posts->links() !!}
@endsection
