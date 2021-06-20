<?php

namespace Tests;

use Faker\Factory;
use Faker\Generator;

trait HasFaker
{
    private ?Generator $faker = null;

    protected function faker(): Generator
    {
        if ($this->faker) {
            return $this->faker;
        }

        $this->faker = $this->makeFaker();

        return $this->faker;
    }

    protected function makeFaker(): Generator
    {
        return Factory::create();
    }
}
