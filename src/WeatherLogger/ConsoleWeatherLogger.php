<?php

namespace App\WeatherLogger;

use App\Model\City;
use App\Model\Forecast;
use App\Model\ForecastDay;
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
     * @param Forecast $forecast
     */
    public function log(City $city, Forecast $forecast): void
    {
        $this->output->writeln(
            sprintf(
                'Processed city %s | %s',
                $city->getName(),
                implode(' - ', array_map(function (ForecastDay $forecast) {
                    return $forecast->getDay()->getCondition()->getText();
                }, $forecast->getForecastday()))
            )
        );
    }
}
