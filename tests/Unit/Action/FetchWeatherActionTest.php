<?php

namespace Tests\Unit\Action;

use App\DataProvider\CityProviderInterface;
use App\DataProvider\ForecastProviderInterface;
use App\Action\FetchWeatherAction;
use App\Model\City;
use App\WeatherLogger\WeatherLoggerInterface;
use Mockery;
use Mockery\MockInterface;
use Tests\DataFactory;
use Tests\TestCase;

class FetchWeatherActionTest extends TestCase
{
    use DataFactory;

    /**
     * @test
     */
    public function it_fetches_cities_and_then_fetches_and_logs_forecasts()
    {
        // Arrange
        $cities = $this->provideCities(3);
        $forecasts = $this->provideForecastsForCities($cities, 3);

        $logger = $this->initializeOutput();
        $cityProvider = $this->initializeCityProvider();
        $forecastProvider = $this->initializeForecastProvider();
        $sut = $this->initializeFetchWeatherAction($cityProvider, $forecastProvider, $logger);

        $cityProvider
            ->shouldReceive('getCities')
            ->andReturn($cities)
        ;

        $forecastProvider
            ->shouldReceive('getForecastsOfCity')
            ->andReturnUsing(function (City $city) use ($forecasts) {
                return $forecasts[$city->getId()];
            })
        ;

        // Act
        $sut($logger);

        // Assert
        $logger->shouldHaveReceived('log')->with($cities[0], $forecasts[$cities[0]->getId()])->once();
        $logger->shouldHaveReceived('log')->with($cities[1], $forecasts[$cities[1]->getId()])->once();
        $logger->shouldHaveReceived('log')->with($cities[2], $forecasts[$cities[2]->getId()])->once();
        ;

    }

    /**
     * @return MockInterface|WeatherLoggerInterface
     */
    private function initializeOutput(): MockInterface
    {
        return Mockery::spy(WeatherLoggerInterface::class);
    }

    /**
     * @return MockInterface|CityProviderInterface
     */
    private function initializeCityProvider(): MockInterface
    {
        return Mockery::spy(CityProviderInterface::class);
    }

    /**
     * @return MockInterface|ForecastProviderInterface
     */
    private function initializeForecastProvider(): MockInterface
    {
        return Mockery::spy(ForecastProviderInterface::class);
    }

    private function initializeFetchWeatherAction(
        CityProviderInterface $cityProvider,
        ForecastProviderInterface $forecastProvider,
        WeatherLoggerInterface $weatherLogger
    ): FetchWeatherAction {
        return new FetchWeatherAction($cityProvider, $forecastProvider, $weatherLogger);
    }
}
