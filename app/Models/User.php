<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Follower;
use App\Models\Message;
use App\Models\Token;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'admin_role',
        'avatar_path',
        'description'
    ];

    protected $hidden = [
        'password'
    ];

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function followed()
    {
        return $this->hasMany(Follower::class, 'followed_user_id');
    }

    public function following()
    {
        return $this->hasMany(Follower::class, 'user_id');
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }

    public function token()
    {
        return $this->hasOne(Token::class);
    }
}
