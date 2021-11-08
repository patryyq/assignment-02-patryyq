<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::all()->random();
            },
            'post_content' => $this->faker->realText(random_int(200, 700))
        ];
    }
}
