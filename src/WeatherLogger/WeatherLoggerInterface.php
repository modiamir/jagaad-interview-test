<?php

namespace App\WeatherLogger;

interface WeatherLoggerInterface
{
    /**
     * @param string $cityName
     * @param array<string> $forecasts
     */
    public function log(string $cityName, array $forecasts): void;
}
