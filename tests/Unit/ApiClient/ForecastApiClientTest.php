<?php

namespace Tests\Unit\ApiClient;

use App\Model\City;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\ApiClient\ForecastApiClient;
use Tests\DataFactory;
use Tests\TestCase;

class ForecastApiClientTest extends TestCase
{
    use DataFactory;

    /**
     * @test
     */
    public function it_fetches_forecast_for_city(): void
    {
        // Arrange
        $city = $this->provideCity();
        $forecastData = $this->provideForecastData();
        $httpClient = $this->initializeHttpClient($city, $forecastData);
        $sut = $this->initializeForecastApiClient($httpClient);

        // Act
        $result = $sut->fetchForecastForCity($city);

        // Assert
        $this->assertEquals($forecastData, $result);
    }

    /**
     * @param City $city
     * @param array<string, mixed> $forecastData
     *
     * @return MockHttpClient
     */
    private function initializeHttpClient(City $city, array $forecastData): MockHttpClient
    {
        $callback = function ($method, $url) use ($forecastData, $city) {
            $validUrl = "https://api.weatherapi.com/v1/forecast.json?key=19bcdf79fdc04d69a0e162412211606" .
                "&q={$city->getLatitude()}%2C{$city->getLongitude()}&days=2";

            if ($url === $validUrl && "GET" === $method) {
                /** @var string $responseContent */
                $responseContent = json_encode($forecastData);

                return new MockResponse($responseContent);
            }

            return new MockResponse('...', ['http_code' => 404]);
        };

        return new MockHttpClient($callback);
    }

    private function initializeForecastApiClient(HttpClientInterface $httpClient): ForecastApiClient
    {
        return new ForecastApiClient($httpClient);
    }
}
