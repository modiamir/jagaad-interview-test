<?php

namespace App\DataProvider;

use App\ApiClient\ForecastApiClientInterface;
use App\Model\City;
use App\Model\Forecast;
use App\Normalizer\DenormalizerInterface;

class ForecastProvider implements ForecastProviderInterface
{
    private ForecastApiClientInterface $apiClient;
    private DenormalizerInterface $denormalizer;

    public function __construct(ForecastApiClientInterface $apiClient, DenormalizerInterface $denormalizer)
    {
        $this->apiClient = $apiClient;
        $this->denormalizer = $denormalizer;
    }

    public function getForecastsOfCity(City $city): Forecast
    {
        $forecastData = $this->apiClient->fetchForecastForCity($city);

        /** @var Forecast $forecast */
        $forecast = $this->denormalizer->denormalize($forecastData, Forecast::class);

        return $forecast;
    }
}
