<?php

namespace App\Action;

use App\WeatherLogger\WeatherLoggerInterface;

interface FetchWeatherActionInterface
{
    public function __invoke(WeatherLoggerInterface $weatherLogger): void;
}
