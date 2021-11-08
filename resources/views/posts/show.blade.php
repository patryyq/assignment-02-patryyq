@extends('layouts.app')

@section('title', 'Post details')

@section('content')

<div class="mt-5">
    <div class="mb-5">
        <div class="d-flex flex-row col-md-12 bg-info justify-content-between align-items-center px-3">
            <div class="p-3 align-items-center">
                <h5 class="m-0 p-0">&#64;<a href="/user/{{ $post->user->nickname }}">{{ $post->user->nickname }}</a>,
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
                    @if (count($post->like->where('user_id', '=', Auth::id())) === 1)
                    <!-- full heart icon -->
                    <i id="{{ $post->id }}" class="fas fa-heart like @if(Auth::guest())guest @endif"></i>
                    @else
                    <!-- empty heart icon -->
                    <i id="{{ $post->id }}" class="far fa-heart like @if(Auth::guest())guest @endif"></i>
                    @endif
                    <span class="position-absolute bottom-0 right-0 translate-middle badge rounded-pill bg-danger">
                        {{ $post->like->count() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="p-3 bg-light">{{ $post->post_content }}</div>
        @if (Auth::check() && ($post->user_id === Auth::id() || Auth::user()->admin_role == 1))
        <form class="d-flex justify-content-end mt-2" action="{{ route('posts.destroy', $post->id) }}" method="POST">
            <a class="mx-2 btn-primary btn" href="{{ route('posts.edit', $post->id) }}">Edit</a>

            @csrf
            @method('DELETE')

            <button type="submit" class="btn-danger btn">Delete</button>
        </form>
        @endif
    </div>
    <div class="mb-5">
        <h2 class="mb-4">Comments ({{$post->comment->count()}}):</h2>
        @if (Auth::check())
        <form action="/comment" method="POST">
            @csrf
            <div class="p-4 mb-5 form-group bg-light border">
                <h3>Add a new comment</h3>
                <label class="sr-only" for="comment_content">Comment content:</label>
                <textarea placeholder="Comment something..." name="comment_content" id="comment_content" row="7" class="form-control form-control-lg my-3 p-2 bg-gray-200 @error('comments') is-invalid @enderror"></textarea>
                <input hidden name="post_id" value="{{$post->id}}">
                @error('comment_content') <div class="alert alert-danger">{{ $message }}
                </div>
                @enderror
                <button type="submit" class="my-2 btn btn-primary">Add comment</button>
            </div>
        </form>
        @endif
        @foreach ($post->comment as $pst)
        <div class="border p-3 mb-3"><b>{{ $pst->user->nickname }}</b>, {{ $pst->created_at->diffForHumans() }}<br>{{ $pst->comment_content }}<br><br>
            @if (Auth::check() && ($pst->user_id === Auth::id() || Auth::user()->admin_role == 1))
            <form class="d-flex justify-content-end mt-2" action="{{ route('comment.destroy', $pst->id) }}" method="POST">
                <a class="m-2 btn-primary btn" href="{{ route('comment.edit', $pst->id) }}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="m-2 btn-danger btn">Delete</button>
            </form>
            @endif
        </div>
        @endforeach
    </div>
</div>
<script src="/../js/like.js"></script>
@endsection