<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Like;
use App\Models\User;
use App\Models\Post;

class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition()
    {
        return [
            'post_id' => function () {
                return Post::all()->random();
            },
            'user_id' => function () {
                return User::all()->random();
            },
            'liked_at' => now()
        ];
    }
}
