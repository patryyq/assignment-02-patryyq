<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Like;
use Tests\TestCase;

class LikeTest extends TestCase
{
    public function test_successful_like_auth()
    {
        $user = $this->getUser(true);
        $post = Post::factory()->create();
        $likeDetails = ['post_id' => $post->id];

        $this->post('/like/' . $post->id, $likeDetails)->assertStatus(201);
        $this->assertDatabaseHas('likes', ['user_id' => $user->id, 'post_id' => $post->id]);
    }

    public function test_unsuccessful_like_unauth()
    {
        $user = $this->getUser();
        $post = Post::factory()->create();
        $likeDetails = ['post_id' => $post->id];

        $this->post('/like/' . $post->id, $likeDetails)->assertStatus(302);
        $this->assertDatabaseMissing('likes', ['user_id' => $user->id, 'post_id' => $post->id]);
    }

    public function test_successful_unlike_auth()
    {
        $user = $this->getUser(true);
        $post = Post::factory()->create();
        $likeDetails = ['post_id' => $post->id];
        $like = Like::factory()->create($likeDetails);

        $this->post('/like/' . $like->post_id, ['post_id' => $like->post_id])->assertStatus(202);
        $this->assertDatabaseMissing('likes', ['user_id' => $user->id, 'post_id' => $post->id]);
    }
}
