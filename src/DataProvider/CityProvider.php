<?php

namespace App\DataProvider;

use App\ApiClient\CityApiClientInterface;
use App\Model\City;
use App\Normalizer\DenormalizerInterface;

class CityProvider implements CityProviderInterface
{
    private CityApiClientInterface $cityApiClient;
    private DenormalizerInterface $denormalizer;

    public function __construct(CityApiClientInterface $cityApiClient, DenormalizerInterface $denormalizer)
    {
        $this->cityApiClient = $cityApiClient;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @return array<City>
     */
    public function getCities(): array
    {
        $citiesData = $this->cityApiClient->fetchCities();

        return array_map(function ($cityData) {
            /** @var City $city */
            $city = $this->denormalizer->denormalize($cityData, City::class);

            return $city;
        }, $citiesData);
    }
}
