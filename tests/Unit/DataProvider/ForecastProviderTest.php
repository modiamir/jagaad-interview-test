<?php

namespace Tests\Unit\DataProvider;

use App\Model\Forecast;
use App\Normalizer\DenormalizerInterface;
use App\ApiClient\ForecastApiClientInterface;
use App\DataProvider\ForecastProvider;
use Mockery\Expectation;
use Mockery\MockInterface;
use Tests\DataFactory;
use Tests\TestCase;

class ForecastProviderTest extends TestCase
{
    use DataFactory;

    /**
     * @test
     */
    public function it_fetches_forecast_and_denormalizes_that(): void
    {
        // Arrange
        $city = $this->provideCity();
        /** @var ForecastApiClientInterface $forecastApi */
        $forecastApi = $this->initializeForecastApiClient();
        /** @var DenormalizerInterface $denormalizer */
        $denormalizer = $this->initializeForecastDenormalizer();
        $sut = $this->initializeForecastProvider($forecastApi, $denormalizer);
        $forecastData = $this->provideForecastData();
        $forecast = $this->provideForecast();

        /** @var MockInterface $forecastApi */
        /** @var Expectation $expectation */
        $expectation = $forecastApi->shouldReceive('fetchForecastForCity');
        $expectation->with($city)->andReturn($forecastData);

        /** @var MockInterface $denormalizer */
        /** @var Expectation $expectation */
        $expectation = $denormalizer->shouldReceive('denormalize');
        $expectation->with($forecastData, Forecast::class)->andReturn($forecast);

        // Act
        $result = $sut->getForecastsOfCity($city);

        // Assert
        $this->assertEquals($forecast, $result);
    }

    private function initializeForecastApiClient(): MockInterface
    {
        return $this->spy(ForecastApiClientInterface::class);
    }

    private function initializeForecastDenormalizer(): MockInterface
    {
        return $this->spy(DenormalizerInterface::class);
    }

    private function initializeForecastProvider(
        ForecastApiClientInterface $forecastApi,
        DenormalizerInterface $denormalizer
    ): ForecastProvider {
        return new ForecastProvider($forecastApi, $denormalizer);
    }
}
