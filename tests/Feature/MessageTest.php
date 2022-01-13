<?php

namespace Tests\Feature;

use App\Models\Message;
use Tests\TestCase;

class MessageTest extends TestCase
{
    public function test_message_added_succesfully_and_present_in_db_auth()
    {
        $user = $this->getUser('auth');
        $otherUser = $this->getUser('not auth');
        $messageDetails = ['message_content' => 'test msg'];

        $this->post('/msg/' . $otherUser->username, $messageDetails)->assertRedirect(route('single-msg', $otherUser->username));
        $this->assertDatabaseHas('messages', ['to_user_id' => $otherUser->id, 'from_user_id' => $user->id]);
    }

    public function test_message_not_added_unauth()
    {
        $user = $this->getUser('not auth');
        $otherUser = $this->getUser('auth');
        $messageDetails = ['message_content' => 'test guest msg'];

        $this->post('/msg/' . $otherUser->username, $messageDetails)->assertStatus(302);
        $this->assertDatabaseMissing('messages', ['to_user_id' => $otherUser->id]);
    }

    public function test_message_empty_content_param_not_added_auth()
    {
        $user = $this->getUser('auth');
        $messageDetails = ['message_content' => ''];

        $this->post('/msg/' . $user->username, $messageDetails)->assertStatus(302);
        $this->assertDatabaseMissing('messages', ['to_user_id' => $user->id]);
    }

    public function test_message_missing_content_param_not_added_auth()
    {
        $user = $this->getUser('auth');

        $this->post('/msg/' . $user->username)->assertStatus(302);
        $this->assertDatabaseMissing('messages', ['to_user_id' => $user->id]);
    }

    public function test_authorised_user_can_see_messages_sent_received()
    {
        $user = $this->getUser('auth');
        $user2 = $this->getUser('auth');

        Message::factory()->count(1)->create([
            'to_user_id' => $user->id,
            'from_user_id' => $user2->id,
            'message_content' => 't3st m3ss4g3'
        ]);
        Message::factory()->count(1)->create([
            'from_user_id' => $user->id,
            'to_user_id' => $user2->id,
            'message_content' => 'test message'
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/messages/' . $user2->username);

        $response->assertOk();
        $response->assertSee('t3st m3ss4g3');
        $response->assertSee('test message');
    }

    public function test_authorised_user_can_see_all_messages()
    {
        $user = $this->getUser('auth');
        Message::factory()->count(1)->create([
            'to_user_id' => $user->id,
            'message_content' => 'test message'
        ]);

        $response = $this->get('/messages');
        $response->assertOk();
        $response->assertSee('test message');
    }

    public function test_mark_message_as_read_auth()
    {
        $user = $this->getUser('auth');
        $user2 = $this->getUser();
        Message::create([
            'to_user_id' => $user2->id
        ]);

        $this->actingAs($user2)->get('/messages/' . $user->username);
        $this->assertDatabaseHas('messages', ['to_user_id' => $user2->id, 'read' => 1]);
    }
}
