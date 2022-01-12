<?php

namespace Tests\Feature;

use App\Models\Follower;
use Tests\TestCase;

class FollowerTest extends TestCase
{
    public function test_successful_follow()
    {
        $this->getUser('auth');
        $user_2 = $this->getUser('not auth');
        $followerDetails = ['followed_user_id' => $user_2->id];

        $this->post('/follower/' . $user_2->id, $followerDetails)->assertStatus(201);
        $this->assertDatabaseHas('followers', $followerDetails);
    }

    public function test_unsuccessful_follow_unauth()
    {
        $this->getUser('not auth');
        $user_2 = $this->getUser('not auth');
        $followerDetails = ['followed_user_id' => $user_2->id];

        $this->post('/follower/' . $user_2->id,  $followerDetails)->assertStatus(302);
        $this->assertDatabaseMissing('followers', $followerDetails);
    }

    public function test_successful_unfollow()
    {
        $this->getUser('auth');
        $user_2 = $this->getUser('not auth');

        $followerDetails = ['followed_user_id' => $user_2->id];
        $follower = Follower::factory()->create($followerDetails);

        $this->post('/follower/' . $follower->followed_user_id, ['followed_user_id' => $follower->followed_user_id])->assertStatus(202);
        $this->assertDatabaseMissing('followers', $followerDetails);
    }
}
