<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function getUser($auth = false)
    {
        $user = User::factory(1)->create()[0];
        if ($auth === 'auth') {
            $this->actingAs($user);
            $this->assertAuthenticated();
        }
        return $user;
    }
}
