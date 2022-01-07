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
                'username' => 'admin',
                'email' => 'admin@email.com',
                'admin_role' => '1'
            ]);

        User::factory()
            ->count(1)
            ->create([
                'username' => 'user',
                'email' => 'user@email.com',
            ]);

        User::factory()
            ->count(38)
            ->create();
    }
}
