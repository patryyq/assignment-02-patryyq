<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    public function test_index_returns_view_auth()
    {
        $this->getUser('auth');

        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_index_returns_view_unauth()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $this->assertGuest();
    }

    public function test_feed_returns_view_auth()
    {
        $this->getUser('auth');

        $response = $this->get(route('feed'));
        $response->assertStatus(200);
    }

    public function test_messages_not_authorised_user_is_redirected()
    {
        $this->getUser('not auth');
        $response = $this->get('/messages');
        $response->assertRedirect('/login');
    }

    public function test_messages_not_authorised_user_is_redirected_from_sepecific()
    {
        $user = $this->getUser('not auth');
        $response = $this->get('/messages/' . $user->username);
        $response->assertRedirect(route('login'));
    }

    public function test_feed_redirects_to_login_view_unauth()
    {
        $response = $this->get(route('feed'));
        $response->assertRedirect(route('login'));
    }

    public function test_login_redirects_to_index_view_auth()
    {
        $this->getUser('auth');

        $response = $this->get(route('login'));
        $response->assertRedirect('/home');
    }

    public function test_forgot_passsword_redirects_to_index_view_auth()
    {
        $this->getUser('auth');

        $response = $this->get('/forgot-password');
        $response->assertRedirect('/home');
    }

    public function test_register_redirects_to_index_view_auth()
    {
        $this->getUser('auth');

        $response = $this->get(route('register'));
        $response->assertRedirect('/home');
    }
}
