<?php

namespace App\WeatherLogger;

use App\Model\City;
use App\Model\Forecast;

interface WeatherLoggerInterface
{
    /**
     * @param City $city
     * @param Forecast $forecast
     */
    public function log(City $city, Forecast $forecast): void;
}
