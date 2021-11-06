<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Like extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'post_id'
    ];

    protected static function booted()
    {
        static::creating(function ($like) {
            if (Auth::id()) {
                $like->user_id = Auth::id();
                $like->liked_at = now();
            }
        });
    }


    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
