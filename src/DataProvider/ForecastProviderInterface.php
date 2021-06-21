<?php

namespace App\DataProvider;

use App\Model\City;
use App\Model\Forecast;

interface ForecastProviderInterface
{
    public function getForecastsOfCity(City $city): Forecast;
}
