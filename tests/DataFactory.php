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

    /**
     * @return array<string,mixed>
     */
    private function provideCityData(): array
    {
        return [
            'id' => $this->faker()->randomNumber(),
            'name' => $this->faker()->city,
            'latitude' => $this->faker()->latitude,
            'longitude' => $this->faker()->longitude,
        ];
    }

    /**
     * @param array<string,string|int|float>|null $cityData
     *
     * @return City
     */
    private function provideCity(array $cityData = null): City
    {
        if (is_null($cityData)) {
            $cityData = $this->provideCityData();
        }

        return (new City())
            ->setId($cityData['id'])
            ->setName($cityData['name'])
            ->setLatitude($cityData['latitude'])
            ->setLongitude($cityData['longitude']);
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
     * @return array<array<string,mixed>>
     */
    private function provideCitiesData(int $count = 1): array
    {
        $cities = [];

        for ($i = 0; $i < $count; $i++) {
            $cities[] = $this->provideCityData();
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

    /**
     * @return array<string,mixed>
     */
    private function provideForecastData(): array
    {
        return [
            "forecastday" => [
                [
                    "date" => $this->faker()->date('Y-m-d'),
                    "date_epoch" => $this->faker()->dateTime->getTimestamp(),
                    "day" => [
                        "condition" => [
                            "text" => $this->faker()->word,
                            "icon" => $this->faker()->url,
                            "code" => $this->faker()->randomNumber(4),
                        ]
                    ]
                ],
                [
                    "date" => $this->faker()->date('Y-m-d'),
                    "date_epoch" => $this->faker()->dateTime->getTimestamp(),
                    "day" => [
                        "condition" => [
                            "text" => $this->faker()->word,
                            "icon" => $this->faker()->url,
                            "code" => $this->faker()->randomNumber(4),
                        ]
                    ]
                ]
            ]
        ];
    }
}
