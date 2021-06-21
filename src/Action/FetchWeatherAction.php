<?php

namespace App\Action;

use App\DataProvider\CityProviderInterface;
use App\DataProvider\ForecastProviderInterface;
use App\WeatherLogger\WeatherLoggerInterface;

class FetchWeatherAction implements FetchWeatherActionInterface
{
    private CityProviderInterface $cityProvider;
    private ForecastProviderInterface $forecastProvider;

    public function __construct(
        CityProviderInterface $cityProvider,
        ForecastProviderInterface $forecastProvider
    ) {
        $this->cityProvider = $cityProvider;
        $this->forecastProvider = $forecastProvider;
    }

    public function __invoke(WeatherLoggerInterface $weatherLogger): void
    {
        $cities = $this->cityProvider->getCities();
        foreach ($cities as $city) {
            $forecasts = $this->forecastProvider->getForecastsOfCity($city);
            $weatherLogger->log($city, $forecasts);
        }
    }
}
