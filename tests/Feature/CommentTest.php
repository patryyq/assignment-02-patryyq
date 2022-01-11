<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Comment;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_comment_added_succesfully_and_present_in_db_auth()
    {
        $user = $this->getUser('auth');
        $post = Post::factory(1)->create();
        $commentDetails = ['post_id' => $post[0]->id, 'comment_content' => 'test comment'];

        $this->post('comment', $commentDetails)->assertStatus(302);
        $this->assertDatabaseHas('comments', ['user_id' => $user->id, 'post_id' => $post[0]->id]);
    }

    public function test_comment_not_added_unauth()
    {
        $user = $this->getUser();
        $post = Post::factory(1)->create();
        $commentDetails = ['post_id' => $post[0]->id, 'comment_content' => 'test comment'];

        $this->assertGuest();
        $this->post('comment', $commentDetails)->assertStatus(302);
        $this->assertDatabaseMissing('comments', ['user_id' => $user->id, 'post_id' => $post[0]->id]);
    }

    public function test_comment_not_added_wrong_post_id_auth()
    {
        $user = $this->getUser('auth');
        $postID = rand(5000, 15000);
        $commentDetails = ['post_id' => $postID, 'comment_content' => 'test comment'];

        $this->post('comment', $commentDetails)->assertStatus(500);
        $this->assertDatabaseMissing('comments', ['user_id' => $user->id, 'post_id' => $postID]);
    }

    public function test_comment_update_proceeds_auth()
    {
        $user = $this->getUser('auth');
        $post = Post::factory(1)->create(['user_id' => $user->id]);
        $comment = Comment::factory(1)->create(['post_id' => $post[0]->id]);
        $oldComment = $comment[0]->comment_content;
        $commentID = $comment[0]->id;
        $commentDetails = ['_method' => "PUT", '_token' => csrf_token(), 'comment_content' => 'updated comment content'];

        $this->post('comment/' . $commentID, $commentDetails)->assertStatus(302);
        $updatedComment = Comment::find($commentID)->first()->comment_content;
        $this->assertNotEquals($oldComment, $updatedComment);
    }

    public function test_comment_update_not_proceed_unauth()
    {
        $user = $this->getUser();
        $post = Post::factory(1)->create(['user_id' => $user->id]);
        $comment = Comment::factory(1)->create(['post_id' => $post[0]->id]);
        $oldComment = $comment[0]->comment_content;
        $commentID = $comment[0]->id;
        $commentDetails = ['_method' => "PUT", '_token' => csrf_token(), 'comment_content' => 'updated comment content'];

        $this->post('comment/' . $commentID, $commentDetails)->assertStatus(302);
        $updatedComment = Comment::find($commentID)->first()->comment_content;
        $this->assertEquals($oldComment, $updatedComment);
    }

    public function test_comment_delete_proceedes_auth()
    {
        $user = $this->getUser('auth');
        $post = Post::factory(1)->create(['user_id' => $user->id]);
        $comment = Comment::factory(1)->create(['post_id' => $post[0]->id]);
        $commentID = $comment[0]->id;
        $deleteCommentDetails = ['_method' => "DELETE", '_token' => csrf_token()];

        $this->post('comment/' . $commentID, $deleteCommentDetails)->assertStatus(302);
        $this->assertDatabaseMissing('comments', ['id' => $commentID]);
    }

    public function test_comment_delete_not_proceed_unauth()
    {
        $user = $this->getUser();
        $post = Post::factory(1)->create(['user_id' => $user->id]);
        $comment = Comment::factory(1)->create(['post_id' => $post[0]->id]);
        $commentID = $comment[0]->id;
        $deleteCommentDetails = ['_method' => "DELETE", '_token' => csrf_token()];

        $this->post('comment/' . $commentID, $deleteCommentDetails)->assertStatus(302);
        $this->assertDatabaseHas('comments', ['id' => $commentID]);
    }
}
