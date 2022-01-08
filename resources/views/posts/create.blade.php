@extends('layouts.app')
@section('title', 'Add post')

@section('content')
    <form action="/posts" method="POST">
        @csrf
        <div class="my-10">
            <label for="post_content">Post:</label>
            <textarea name="post_content" id="post_content" row="5"
                class=" p-2 bg-gray-200 @error('comments') is-invalid @enderror"></textarea>
            @error('post_content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-blue">Add</button>
    </form>
@endsection
