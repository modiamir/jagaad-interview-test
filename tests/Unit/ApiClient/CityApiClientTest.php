<?php

namespace Tests\Unit\ApiClient;

use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\ApiClient\CityApiClient;
use Tests\DataFactory;
use Tests\TestCase;

class CityApiClientTest extends TestCase
{
    use DataFactory;

    /**
     * @test
     */
    public function it_fetches_list_of_cities(): void
    {
        // Arrange
        $citiesData = $this->provideCitiesData(3);
        $httpClient = $this->initializeHttpClient($citiesData);
        $sut = $this->initializeCityApiClient($httpClient);

        // Act
        $result = $sut->fetchCities();

        // Assert
        $this->assertEquals($citiesData, $result);
    }

    /**
     * @param array<array<string,mixed>> $citiesData
     * @return MockHttpClient
     */
    private function initializeHttpClient(array $citiesData): MockHttpClient
    {
        $callback = function ($method, $url, $options) use ($citiesData){
            if (
                "GET" === $method &&
                $url === 'https://sandbox.musement.com/api/v3/cities' &&
                isset($options['normalized_headers']) &&
                isset($options['normalized_headers']['accept']) &&
                in_array('Accept: application/json', $options['normalized_headers']['accept'])
            ) {
                /** @var string $responseContent */
                $responseContent = json_encode($citiesData);

                return new MockResponse($responseContent);
            }

            return new MockResponse('...', ['http_code' => 404]);
        };

        return new MockHttpClient($callback);
    }

    private function initializeCityApiClient(HttpClientInterface $httpClient): CityApiClient
    {
        return new CityApiClient($httpClient);
    }
}
