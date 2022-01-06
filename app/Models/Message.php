<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = ['message_sent_at'];
    protected $fillable = [
        'message_content',
        'to_user_id'
    ];

    protected static function booted()
    {
        static::creating(function ($message) {
            if (Auth::id()) {
                $message->from_user_id = Auth::id();
            }
        });
    }

    public function from_user()
    {
        return $this->belongsTo(User::class);
    }

    public function to_user()
    {
        return $this->belongsTo(User::class);
    }
}
