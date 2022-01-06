<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Message;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        return [
            'to_user_id' => function () {
                return User::all()->random();
            },
            'from_user_id' => function () {
                return User::all()->random();
            },
            'message_content' => $this->faker->realText(random_int(20, 300)),
            'read' => 0,
        ];
    }
}
