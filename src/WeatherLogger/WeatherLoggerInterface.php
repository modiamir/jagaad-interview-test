<?php

namespace App\WeatherLogger;

use App\Model\City;
use App\Model\Forecast;

interface WeatherLoggerInterface
{
    /**
     * @param City $city
     * @param array<Forecast> $forecasts
     */
    public function log(City $city, array $forecasts): void;
}
