@extends('layouts.app')
@section('title', 'Edit post')

@section('content')
    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="p-4 my-5 form-group bg-light border">
            <h3>Edit post content</h3>
            <label class="sr-only" for="post_content">Edit post content:</label>
            <textarea class="form-control form-control-lg my-3 p-2 bg-gray-200 @error('comments') is-invalid @enderror"
                name="post_content" id="post_content" row="7">{{ $post->post_content }}</textarea>
            @error('post_content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="my-2 btn btn-primary">Update post</button>
        </div>
    </form>
@endsection
