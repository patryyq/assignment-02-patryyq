<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Follower extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'followed_user_id'
    ];

    protected static function booted()
    {
        static::creating(function ($follow) {
            if (Auth::id()) {
                $follow->user_id = Auth::id();
                $follow->followed_at = now();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function followed_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
