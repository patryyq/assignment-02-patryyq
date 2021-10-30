<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@email.com'
            ]);

        User::factory()
            ->count(100)
            ->create();
    }
}
