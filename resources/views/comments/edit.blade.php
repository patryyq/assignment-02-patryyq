@extends('layouts.app')
@section('title', 'Edit comment')

@section('content')
    <form action="{{ route('comment.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="p-4 my-5 form-group bg-light border">
            <h3>Edit comment content</h3>
            <label class="sr-only" for="comment_content">Edit comment content:</label>
            <textarea class="form-control form-control-lg my-3 p-2 bg-gray-200 @error('comments') is-invalid @enderror"
                name="comment_content" id="comment_content" row="7">{{ $comment->comment_content }}</textarea>
            @error('comment_content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="my-2 btn btn-primary">Update comment</button>
        </div>
    </form>
@endsection
