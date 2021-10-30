<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reply;
use App\Models\Post;
use App\Models\User;

class ReplyFactory extends Factory
{
    protected $model = Reply::class;

    public function definition()
    {
        return [
            'post_id' => function () {
                return Post::all()->random();
            },
            'user_id' => function () {
                return User::all()->random();
            },
            'reply_content' => $this->faker->realText(150)
        ];
    }
}
