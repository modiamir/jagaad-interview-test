<?php

namespace Tests;

use App\Model\City;
use App\Model\Forecast;

trait DataFactory
{
    use HasFaker;

    private function provideCity(): City
    {
        return (new City())->setId($this->faker()->randomNumber())->setName($this->faker()->city);
    }

    private function provideForecast(): Forecast
    {
        return (new Forecast())->setId($this->faker()->randomNumber())->setStatus($this->faker()->word);
    }

    /**
     * @return array<City>
     */
    private function provideCities(int $count = 1): array
    {
        $cities = [];

        for ($i = 0; $i < $count; $i++) {
            $cities[] = $this->provideCity();
        }

        return $cities;
    }

    /**
     * @return array<Forecast>
     */
    private function provideForecasts(int $count = 1): array
    {
        $forecasts = [];

        for ($i = 0; $i < $count; $i++) {
            $forecasts[] = $this->provideForecast();
        }

        return $forecasts;
    }

    /**
     * @param array<City> $cities
     * @param int $countPerCity
     *
     * @return array<int,array<Forecast>>
     */
    private function provideForecastsForCities(array $cities, int $countPerCity = 1): array
    {
        $forecasts = [];

        foreach ($cities as $city) {
            if (!$city->getId()) {
                continue;
            }
            $forecasts[(int)$city->getId()] = $this->provideForecasts($countPerCity);
        }

        return $forecasts;
    }
}
