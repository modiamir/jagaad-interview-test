<?php

namespace Tests;

use App\Model\City;
use App\Model\Forecast;
use App\Model\ForecastCondition;
use App\Model\ForecastDay;
use App\Model\ForecastDayElement;

trait DataFactory
{
    use HasFaker;

    private function provideCity(): City
    {
        return (new City())->setId($this->faker()->randomNumber())->setName($this->faker()->city);
    }

    private function provideForecastCondition(): ForecastCondition
    {
        return (new ForecastCondition())
            ->setCode($this->faker()->randomNumber(4))
            ->setIcon($this->faker()->url)
            ->setText($this->faker()->word);
    }

    private function provideForecastDayElement(): ForecastDayElement
    {
        return (new ForecastDayElement())->setCondition($this->provideForecastCondition());
    }

    private function provideForecastDay(): ForecastDay
    {
        return (new ForecastDay())
            ->setDate($this->faker()->date('Y-m-d'))
            ->setDateEpoch($this->faker()->dateTime->getTimestamp())
            ->setDay($this->provideForecastDayElement());
    }

    /**
     * @return array<ForecastDay>
     */
    private function provideForecastDays(int $count = 1): array
    {
        /** @var array<ForecastDay> $forecasts */
        $forecasts = [];

        for ($i = 0; $i < $count; $i++) {
            $forecasts[] = $this->provideForecastDay();
        }

        return $forecasts;
    }

    private function provideForecast(int $forecastDaysCount = 1): Forecast
    {
        return (new Forecast())->setForecastday($this->provideForecastDays($forecastDaysCount));
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
     * @param array<City> $cities
     *
     * @return array<int,Forecast>
     */
    private function provideForecastsForCities(array $cities): array
    {
        $forecasts = [];

        foreach ($cities as $city) {
            if (!$city->getId()) {
                continue;
            }
            $forecasts[(int)$city->getId()] = $this->provideForecast();
        }

        return $forecasts;
    }
}
