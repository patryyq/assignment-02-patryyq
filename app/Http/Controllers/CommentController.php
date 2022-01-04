<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Post $post, Request $request)
    {
        $request->validate([
            'comment_content' => 'required'
        ]);

        $post = Post::find($request->post_id)->first();
        if (!$post->id || Auth::guest()) return redirect('/', 400)->with('success', 'Comment not added. Error occured.');

        $comment = Comment::create($request->all());
        return redirect('/post/' . strval($comment->post_id))
            ->with('success', 'Comment added successfully.');
    }

    public function edit(Comment $comment)
    {
        return view('comments.edit', [
            'comment' => $comment
        ]);
    }

    public function destroy(Post $post, Comment $comment)
    {
        $postID = $comment->post_id;
        $comment->delete();

        return redirect('/post/' .  $postID)
            ->with('success', 'Comment deleted successfully.');
    }


    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comment_content' => 'required'
        ]);

        $comment->update($request->all());
        return redirect('/post/' . strval($comment->post_id))
            ->with('success', 'Comment updated successfully.');
    }
}
