<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\LikeSeeder;
use Database\Seeders\ReplySeeder;
use Database\Seeders\FollowerSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            LikeSeeder::class,
            ReplySeeder::class,
            FollowerSeeder::class
        ]);
    }
}
