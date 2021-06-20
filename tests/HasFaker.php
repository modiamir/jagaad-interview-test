<?php

namespace Tests;

use Faker\Factory;
use Faker\Generator;

trait HasFaker
{
    protected ?Generator $faker = null;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker();
    }

    protected function makeFaker(): Generator
    {
        return Factory::create();
    }
}
