<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\LikeSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\FollowerSeeder;
use Database\Seeders\MessageSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            LikeSeeder::class,
            CommentSeeder::class,
            FollowerSeeder::class,
            MessageSeeder::class
        ]);
    }
}
