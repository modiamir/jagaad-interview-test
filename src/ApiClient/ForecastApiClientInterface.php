<?php

namespace App\ApiClient;

use App\Model\City;

interface ForecastApiClientInterface
{
    /**
     * @return array<string,mixed>
     */
    public function fetchForecastForCity(City $city): array;
}
