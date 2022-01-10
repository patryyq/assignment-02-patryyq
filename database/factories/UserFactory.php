<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'username' => $this->faker->unique()->firstName() . '_'  . Str::random(5),
            'email' => $this->faker->unique()->safeEmail(),
            'avatar_path' => 'default/' . random_int(1, 11) . '.jpg',
            'description' => $this->faker->realText(100),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password = password
        ];
    }
}
