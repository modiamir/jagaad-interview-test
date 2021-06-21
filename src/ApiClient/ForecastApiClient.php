<?php

namespace App\ApiClient;

use App\Model\City;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ForecastApiClient implements ForecastApiClientInterface
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param City $city
     *
     * @return array<string,mixed>
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function fetchForecastForCity(City $city): array
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.weatherapi.com/v1/forecast.json',
            [
                'query' => [
                    'key' => '19bcdf79fdc04d69a0e162412211606', // This must be read from config (or env variables)
                    'q' => "{$city->getLatitude()},{$city->getLongitude()}",
                    'days' => 2,
                ],
            ]
        );

        return $response->toArray(true);
    }
}
