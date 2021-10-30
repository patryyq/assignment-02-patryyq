<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'post_id' => function () {
                return Post::all()->random();
            },
            'user_id' => function () {
                return User::all()->random();
            },
            'comment_content' => $this->faker->realText(150)
        ];
    }
}
