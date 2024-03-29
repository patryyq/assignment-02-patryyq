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
        $users = User::inRandomOrder()->take(2)->pluck('id');

        return [
            'to_user_id' => $users->first(),
            'from_user_id' => $users->last(),
            'message_content' => $this->faker->realText(random_int(20, 500)),
            'read' => 1,
        ];
    }
}
