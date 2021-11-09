<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    public function test_index_returns_view_auth()
    {
        $this->getUser(true);

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
        $this->getUser(true);

        $response = $this->get(route('feed'));
        $response->assertStatus(200);
    }

    public function test_feed_redirects_to_login_view_unauth()
    {
        $response = $this->get(route('feed'));
        $response->assertRedirect(route('login'));
    }

    public function test_login_redirects_to_index_view_auth()
    {
        $this->getUser(true);

        $response = $this->get(route('login'));
        $response->assertRedirect('/home');
    }

    public function test_register_redirects_to_index_view_auth()
    {
        $this->getUser(true);

        $response = $this->get(route('register'));
        $response->assertRedirect('/home');
    }
}
