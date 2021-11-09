<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_register_form_view()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.create');
    }

    public function test_register_validation_error()
    {
        $response = $this->post('/register', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['username', 'email', 'password']);
    }

    public function test_successful_register()
    {
        $registerData = ['username' => 'test_username', 'email' => 'test@email.com', 'password' => 'test_password_123'];
        $this->post('/register', $registerData)->assertRedirect('/');
    }

    public function test_successful_authentication()
    {
        $username = 'test_username1';
        $email = 'test1@email.com';
        $password = 'test_password_123';

        User::factory()->create([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $loginData = ['email' => $email, 'password' => $password];
        $this->post('/login', $loginData)->assertStatus(302);
        $this->assertAuthenticated();
    }

    public function test_authentication_wrong_credentials()
    {
        $username = 'test_username8';
        $email = 'test8@email.com';
        $password = 'test_password_123';

        User::factory()->create([
            'username' => $username,
            'email' => $email . 'a',
            'password' => Hash::make($password),
        ]);

        $loginData = ['email' => $email, 'password' => $password];
        $this->post('/login', $loginData)->assertStatus(302);
        $this->assertGuest();
    }
}
