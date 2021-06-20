<?php

namespace App\Action;

use App\DataProvider\CityProviderInterface;
use App\DataProvider\ForecastProviderInterface;
use App\WeatherLogger\WeatherLoggerInterface;

class FetchWeatherAction implements FetchWeatherActionInterface
{
    private CityProviderInterface $cityProvider;
    private ForecastProviderInterface $forecastProvider;
    private WeatherLoggerInterface $weatherLogger;

    public function __construct(
        CityProviderInterface $cityProvider,
        ForecastProviderInterface $forecastProvider,
        WeatherLoggerInterface $weatherLogger
    ) {
        $this->cityProvider = $cityProvider;
        $this->forecastProvider = $forecastProvider;
        $this->weatherLogger = $weatherLogger;
    }

    public function __invoke(WeatherLoggerInterface $weatherLogger): void
    {
        $cities = $this->cityProvider->getCities();
        foreach ($cities as $city) {
            $forecasts = $this->forecastProvider->getForecastsOfCity($city);
            $this->weatherLogger->log($city, $forecasts);
        }
    }
}
