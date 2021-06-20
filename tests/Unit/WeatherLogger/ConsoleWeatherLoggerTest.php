<?php

namespace Tests\Unit\WeatherLogger;

use Mockery;
use Tests\TestCase;
use App\WeatherLogger\WeatherLoggerInterface;
use App\WeatherLogger\ConsoleWeatherLogger;
use Mockery\MockInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleWeatherLoggerTest extends TestCase
{
    public function test_it_calls_given_output_writeln_method()
    {
        // Arrange
        $locationName = $this->faker->city;
        $forecasts = [$this->faker->word, $this->faker->city];
        $output = $this->initializeOutput();
        $sut = $this->initializeLogger($output);
        $expectedLoggedEntry = sprintf(
            "Processed city %s | %s - %s",
            $locationName,
            $forecasts[0],
            $forecasts[1]
        );

        // Act
        $sut->log($locationName, $forecasts);

        // Assert
        $output
            ->shouldHaveReceived('writeln')
            ->once()
            ->with($expectedLoggedEntry)
        ;
    }

    /**
     * @return MockInterface|OutputInterface
     */
    private function initializeOutput(): MockInterface
    {
        return Mockery::spy(OutputInterface::class);
    }

    public function initializeLogger(OutputInterface $output): WeatherLoggerInterface
    {
        return new ConsoleWeatherLogger($output);
    }
}
