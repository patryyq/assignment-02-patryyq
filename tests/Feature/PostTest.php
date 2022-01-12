<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function test_post_added_succesfully_and_present_in_db_auth()
    {
        $user = $this->getUser('auth');
        $postDetails = ['post_content' => 'test post test post'];

        $this->post('posts', $postDetails)->assertStatus(302);
        $this->assertDatabaseHas('posts', ['user_id' => $user->id]);
    }

    public function test_post_not_added_unauth()
    {
        $user = $this->getUser('not auth');
        $postDetails = ['post_content' => 'test guest post'];

        $this->post('posts', $postDetails)->assertStatus(302);
        $this->assertDatabaseMissing('posts', ['user_id' => $user->id]);
    }

    public function test_post_missing_field_param_not_added_auth()
    {
        $user = $this->getUser('auth');

        $this->post('posts', [])->assertStatus(302);
        $this->assertDatabaseMissing('posts', ['user_id' => $user->id]);
    }

    public function test_authorised_user_can_post_update()
    {
        $user = $this->getUser('auth');
        $post = Post::factory(1)->create(['user_id' => $user->id]);
        $oldPost = $post[0]->post_content;
        $postID = $post[0]->id;
        $postDetails = ['_method' => "PUT", '_token' => csrf_token(), 'post_content' => 'updated post content'];

        $this->post('posts/' . $postID, $postDetails)->assertStatus(302);
        $updatedPost = Post::find($postID)->first()->post_content;
        $this->assertNotEquals($oldPost, $updatedPost);
    }

    public function test_not_authorised_user_can_not_post_update()
    {
        $user = $this->getUser();
        $post = Post::factory(1)->create(['user_id' => $user->id]);
        $oldPost = $post[0]->post_content;
        $postID = $post[0]->id;
        $postDetails = ['_method' => "PUT", '_token' => csrf_token(), 'post_content' => 'updated post content'];

        $this->post('posts/' . $postID, $postDetails)->assertStatus(302);
        $updatedPost = Post::find($postID)->first()->post_content;
        $this->assertEquals($oldPost, $updatedPost);
    }

    public function test_authorised_user_can_post_delete()
    {
        $user = $this->getUser('auth');
        $post = Post::factory(1)->create(['user_id' => $user->id]);
        $postID = $post[0]->id;
        $deletePostDetails = ['_method' => "DELETE", '_token' => csrf_token()];

        $this->post('posts/' . $postID, $deletePostDetails)->assertStatus(302);
        $this->assertDatabaseMissing('posts', ['id' => $postID]);
    }

    public function test_not_authorised_user_can_not_post_delete()
    {
        $user = $this->getUser('not auth');
        $post = Post::factory(1)->create(['user_id' => $user->id]);
        $postID = $post[0]->id;
        $deletePostDetails = ['_method' => "DELETE", '_token' => csrf_token()];

        $this->post('posts/' . $postID, $deletePostDetails)->assertStatus(302);
        $this->assertDatabaseHas('posts', ['id' => $postID]);
    }
}
