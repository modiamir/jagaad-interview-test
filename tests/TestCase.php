<?php

namespace Tests;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use HasFaker;

    protected function tearDown(): void
    {
        $this->faker = null;
        $this->addToAssertionCount(
            Mockery::getContainer()->mockery_getExpectationCount()
        );
    }

    /**
     * @param string $class
     *
     * @return MockInterface
     */
    protected function spy(string $class): MockInterface
    {
        /** @phpstan-ignore-next-line Mockery::spy always returns instance of MockInterface but its typehint is wrong */
        return Mockery::spy($class);
    }
}
