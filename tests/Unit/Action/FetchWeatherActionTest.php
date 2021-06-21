<?php

namespace Tests\Unit\Action;

use App\DataProvider\CityProviderInterface;
use App\DataProvider\ForecastProviderInterface;
use App\Action\FetchWeatherAction;
use App\Model\City;
use App\WeatherLogger\WeatherLoggerInterface;
use Mockery\Expectation;
use Mockery\MockInterface;
use Tests\DataFactory;
use Tests\TestCase;

class FetchWeatherActionTest extends TestCase
{
    use DataFactory;

    /**
     * @test
     */
    public function it_fetches_cities_and_then_fetches_and_logs_forecasts(): void
    {
        // Arrange
        $cities = $this->provideCities(3);
        $forecasts = $this->provideForecastsForCities($cities);

        /** @var WeatherLoggerInterface $logger */
        $logger = $this->initializeOutput();
        /** @var CityProviderInterface $cityProvider */
        $cityProvider = $this->initializeCityProvider();
        /** @var ForecastProviderInterface $forecastProvider */
        $forecastProvider = $this->initializeForecastProvider();
        $sut = $this->initializeFetchWeatherAction($cityProvider, $forecastProvider, $logger);

        /** @var MockInterface $cityProvider */
        /** @var Expectation $expectation */
        $expectation = $cityProvider->shouldReceive('getCities');
        $expectation->andReturn($cities);

        /** @var MockInterface $forecastProvider */
        /** @var Expectation $expectation */
        $expectation = $forecastProvider->shouldReceive('getForecastsOfCity');
        $expectation->andReturnUsing(function (City $city) use ($forecasts) {
            return $forecasts[$city->getId()];
        });

        // Act
        $sut($logger);

        // Assert
        /** @var MockInterface $logger */
        $logger->shouldHaveReceived('log')->with($cities[0], $forecasts[$cities[0]->getId()])->once();
        $logger->shouldHaveReceived('log')->with($cities[1], $forecasts[$cities[1]->getId()])->once();
        $logger->shouldHaveReceived('log')->with($cities[2], $forecasts[$cities[2]->getId()])->once();
    }

    private function initializeOutput(): MockInterface
    {
        return $this->spy(WeatherLoggerInterface::class);
    }

    private function initializeCityProvider(): MockInterface
    {
        return $this->spy(CityProviderInterface::class);
    }

    private function initializeForecastProvider(): MockInterface
    {
        return $this->spy(ForecastProviderInterface::class);
    }

    private function initializeFetchWeatherAction(
        CityProviderInterface $cityProvider,
        ForecastProviderInterface $forecastProvider,
        WeatherLoggerInterface $weatherLogger
    ): FetchWeatherAction {
        return new FetchWeatherAction($cityProvider, $forecastProvider, $weatherLogger);
    }
}
