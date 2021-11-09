<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use App\Models\Follower;

class FollowerSeeder extends Seeder
{
    protected $numberOfFollowersToSeed = 1000;

    public function run()
    {
        for ($i = 0; $i < $this->numberOfFollowersToSeed; $i++) {
            try {
                Follower::factory()
                    ->create();
            } catch (QueryException $e) {
            }
        }
    }
}
