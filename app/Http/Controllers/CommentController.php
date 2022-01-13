<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function isCommentOwnerOrAdmin($comment)
    {
        return ($comment->user_id != Auth::id() && Auth::user()->admin_role != 1) ? false : true;
    }

    public function store(Request $request)
    {
        $request->validate([
            'comment_content' => 'required'
        ]);

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

    public function destroy(Comment $comment)
    {
        if (!$this->isCommentOwnerOrAdmin($comment)) return redirect('/');

        $postID = $comment->post_id;
        $comment->delete();

        return redirect('/post/' .  $postID)
            ->with('success', 'Comment deleted successfully.');
    }


    public function update(Request $request, Comment $comment)
    {
        if (!$this->isCommentOwnerOrAdmin($comment)) return redirect('/');

        $request->validate([
            'comment_content' => 'required'
        ]);
        $comment->update($request->all());

        return redirect('/post/' . strval($comment->post_id))
            ->with('success', 'Comment updated successfully.');
    }
}
