<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Token;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Upload;

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

    public function test_correct_credential_successful_redirect_2fa()
    {
        $email = 'test1@email.com';
        $password = 'test_password_123';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $loginData = ['email' => $email, 'password' => $password];
        $response = $this->followingRedirects()->post('/login', $loginData)->assertSee('2FA');
        $this->assertGuest();
    }

    public function test_not_authenticate_with_wrong_credentials()
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

    public function test_authorised_user_can_lookup_usernames()
    {
        $this->getUser('auth');
        $user = $this->getUser();

        $response = $this->get('/username/' . $user->username);
        $response->assertOk();
        $response->assertSee($user->username);
    }

    public function test_not_authorised_user_can_not_lookup_usernames()
    {
        $this->getUser();
        $user = $this->getUser();

        $response = $this->get('/username/' . $user->username);
        $response->assertDontSee($user->username);
    }

    public function test_not_authorised_user_can_not_upload_image()
    {
        Storage::fake('images');
        $this->getUser();
        $file = UploadedFile::fake()->image('some-image.jpg');

        $this->followingRedirects()->post('/upload-image', ['image' => $file]);
        Storage::assertMissing(storage_path('app/public/images/some-image.jpg'));
    }

    public function test_authorised_user_can_upload_image()
    {
        Storage::fake('images');
        $this->getUser('auth');
        $file = UploadedFile::fake()->image('some-image.jpg');

        $this->followingRedirects()->post('/upload-image', ['image' => $file]);
        $this->assertFileExists(storage_path('app/public/images/') . 'some-image.jpg');
    }

    public function test_user_can_see_change_password_form_with_good_link()
    {
        $user = $this->getUser('not auth');
        $tkn = Str::random(40);

        Token::create(['user_id' => $user->id, 'token' => $tkn, 'token_updated_at' => now()]);

        $this->followingRedirects()->get('/reset-password/' . $user->email . '/' . $tkn)->assertSee('password_confirmation');
    }

    public function test_user_can_change_password_with_good_link()
    {
        $user = $this->getUser('not auth');
        $tkn = Str::random(40);

        Token::create(['user_id' => $user->id, 'token' => $tkn, 'token_updated_at' => now()]);

        $this->followingRedirects()->post('/reset-password/' . $user->email . '/' . $tkn, ['password' => 'newPassword', 'password_confirmation' => 'newPassword'])->assertSee('Password changed successfully.');
    }
}
