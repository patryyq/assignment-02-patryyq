@extends('layouts.app')

@section('title', 'Posts details')

@section('content')
<?php
// echo '<pre>';
// echo var_dump($posts);
// echo '</pre>';
?>
<div>
    <div class="mb-5">
        <div class="d-flex flex-row col-md-12 bg-info justify-content-between">
            <div class="p-3">&#64;{{ $posts->user->nickname }}, {{ $posts->created_at->diffForHumans() }}</div>
            <div class="p-3"></div>
            <div class="p-3">
                <div style="position:relative">
                    <span class="position-absolute top-100 start-0 translate-middle badge rounded-pill bg-danger">
                        {{ $posts->like_count }}
                    </span>
                </div>
                @if (isset($posts->like[0]))
                <!-- full heart (liked) -->
                <i id="{{ $posts->id }}" class="fas fa-heart like"></i>
                @else
                <!-- empty heart (not liked) -->
                <i id="{{ $posts->id }}" class="far fa-heart like"></i>
                @endif
            </div>
        </div>
        <div class="p-3 bg-light">{{ $posts->post_content }}</div>
        <form action="{{ route('posts.destroy', $posts->id) }}" method="POST">
            <a class="btn btn-blue" href="{{ route('posts.show', $posts->id) }}">Show</a>
            <a class="btn btn-blue" href="{{ route('posts.edit', $posts->id) }}">Edit</a>

            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-red">Delete</button>
        </form>
    </div>
</div>
<script src="../js/like.js"></script>
@endsection