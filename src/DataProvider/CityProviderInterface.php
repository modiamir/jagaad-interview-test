<?php

namespace App\DataProvider;

use App\Model\City;

interface CityProviderInterface
{
    /**
     * @return array<City>
     */
    public function getCities(): array;
}
