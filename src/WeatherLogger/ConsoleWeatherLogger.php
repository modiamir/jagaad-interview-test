<?php

namespace App\WeatherLogger;

use Symfony\Component\Console\Output\OutputInterface;

class ConsoleWeatherLogger implements WeatherLoggerInterface
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function log(string $cityName, array $forecasts): void
    {
        $this->output->writeln(
            sprintf(
                'Processed city %s | %s',
                $cityName,
                implode(' - ', $forecasts)
            )
        );
    }
}
