<?php

namespace App\ApiClient;

interface CityApiClientInterface
{
    /**
     * @return array<array<string, string|int|float>>
     */
    public function fetchCities(): array;
}
