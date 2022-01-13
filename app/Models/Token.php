<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Token extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tokens';
    protected $fillable = [
        'user_id',
        'code_2fa',
        'token',
        'code_2fa_updated_at',
        'token_updated_at'
    ];

    public function tokenCode()
    {
        return $this->belongsTo(User::class);
    }
}
