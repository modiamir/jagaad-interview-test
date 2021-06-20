<?php

namespace Tests\Unit\WeatherLogger;

use Tests\DataFactory;
use Tests\TestCase;
use App\WeatherLogger\ConsoleWeatherLogger;
use Mockery\MockInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleWeatherLoggerTest extends TestCase
{
    use DataFactory;

    public function test_it_calls_given_output_writeln_method() :void
    {
        // Arrange
        $city = $this->provideCity();
        $forecasts = $this->provideForecasts(2);
        /** @var OutputInterface $output */
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
        /** @var MockInterface $output */
        $output
            ->shouldHaveReceived('writeln')
            ->once()
            ->with($expectedLoggedEntry)
        ;
    }

    private function initializeOutput(): MockInterface
    {
        return $this->spy(OutputInterface::class);
    }

    public function initializeLogger(OutputInterface $output): ConsoleWeatherLogger
    {
        return new ConsoleWeatherLogger($output);
    }
}
