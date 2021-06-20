<?php

namespace Tests\Unit\WeatherLogger;

use Mockery;
use Tests\DataFactory;
use Tests\TestCase;
use App\WeatherLogger\WeatherLoggerInterface;
use App\WeatherLogger\ConsoleWeatherLogger;
use Mockery\MockInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleWeatherLoggerTest extends TestCase
{
    use DataFactory;

    public function test_it_calls_given_output_writeln_method()
    {
        // Arrange
        $city = $this->provideCity();
        $forecasts = $this->provideForecasts(2);
        $output = $this->initializeOutput();
        $sut = $this->initializeLogger($output);
        $expectedLoggedEntry = sprintf(
            "Processed city %s | %s - %s",
            $city->getName(),
            $forecasts[0]->getStatus(),
            $forecasts[1]->getStatus()
        );

        // Act
        $sut->log($city, $forecasts);

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
