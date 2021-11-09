<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeedTest extends TestCase
{
    public function test_if_seeders_works()
    {
        $response = $this->seed();
        $response->assertTrue(true);
    }
}
