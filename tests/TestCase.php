<?php

namespace Tests;

use Mockery;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use HasFaker;

    protected function setUp(): void
    {
        $this->setUpFaker()
        ;
    }

    protected function tearDown(): void
    {
        $this->faker = null;
        $this->addToAssertionCount(
            Mockery::getContainer()->mockery_getExpectationCount()
        );
    }
}
