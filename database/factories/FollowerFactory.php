<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Follower;

class FollowerFactory extends Factory
{
    protected $model = Follower::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::all()->random();
            },
            'followed_user_id' => function () {
                return User::all()->random();
            },
            'followed_at' => now()
        ];
    }
}
