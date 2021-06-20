<?php

namespace App\WeatherLogger;

use App\Model\City;
use App\Model\Forecast;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleWeatherLogger implements WeatherLoggerInterface
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param City $city
     * @param array<Forecast> $forecasts
     */
    public function log(City $city, array $forecasts): void
    {
        $this->output->writeln(
            sprintf(
                'Processed city %s | %s',
                $city->getName(),
                implode(' - ', array_map(function (Forecast $forecast) {
                    return $forecast->getStatus();
                }, $forecasts))
            )
        );
    }
}
