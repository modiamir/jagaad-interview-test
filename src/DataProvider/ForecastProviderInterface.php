<?php

namespace App\DataProvider;

use App\Model\City;
use App\Model\Forecast;

interface ForecastProviderInterface
{
    /**
     * @return array<Forecast>
     */
    public function getForecastsOfCity(City $city): array;
}
