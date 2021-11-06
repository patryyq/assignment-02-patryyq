<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use App\Models\Like;

class LikeSeeder extends Seeder
{
    protected $numberOfLikesToSeed = 800;

    public function run()
    {
        for ($i = 0; $i < $this->numberOfLikesToSeed; $i++) {
            try {
                Like::factory()
                    ->create();
            } catch (QueryException $e) {
            }
        }
    }
}
