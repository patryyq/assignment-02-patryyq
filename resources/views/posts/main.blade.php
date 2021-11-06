@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<?php
// echo '<pre>';
// echo var_dump($posts);
// echo '</pre>';
?>
<div>
    @foreach ($posts as $post)
    <div class="mb-5">
        <div class="d-flex flex-row col-md-12 bg-info justify-content-between">
            <div class="p-3">&#64;{{ $post->user->nickname }}, {{ $post->created_at->diffForHumans() }}</div>
            <div class="p-3"></div>
            <div class="p-3">
                <div style="position:relative">
                    <span class="position-absolute top-100 start-0 translate-middle badge rounded-pill bg-danger">
                        {{ $post->like_count }}
                    </span>
                </div>
                @if (isset($post->like[0]))
                <!-- full heart (liked) -->
                <i id="{{ $post->id }}" class="fas fa-heart like"></i>
                @else
                <!-- empty heart (not liked) -->
                <i id="{{ $post->id }}" class="far fa-heart like"></i>
                @endif
            </div>
        </div>
        <div class="p-3 bg-light">{{ $post->post_content }}</div>
        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
            <a class="btn btn-blue" href="{{ route('posts.show', $post->id) }}">Show</a>
            <a class="btn btn-blue" href="{{ route('posts.edit', $post->id) }}">Edit</a>

            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-red">Delete</button>
        </form>
    </div>
    @endforeach
</div>
<script src="js/like.js"></script>
{!! $posts->links() !!}
@endsection