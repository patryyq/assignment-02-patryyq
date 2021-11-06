@extends('layouts.app')

@section('title', 'Edit post')

@section('content')
<form action="{{ route('posts.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class=" my-10">
        <label for="post_content">Post:</label>
        <textarea name="post_content" id="post_content" row="5" class=" p-2 bg-gray-200 @error('post_content') is-invalid @enderror">{{ $post->post_content }}</textarea>

        @error('post_content')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-blue">Update</button>
</form>
@endsection