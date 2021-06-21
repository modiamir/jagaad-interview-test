<?php

namespace Tests\Unit\DataProvider;

use App\Model\City;
use App\Normalizer\DenormalizerInterface;
use App\ApiClient\CityApiClientInterface;
use App\DataProvider\CityProvider;
use Mockery\Expectation;
use Mockery\MockInterface;
use Tests\DataFactory;
use Tests\TestCase;

class CityProviderTest extends TestCase
{
    use DataFactory;

    /**
     * @test
     */
    public function it_fetches_cities_and_denormalizes_them(): void
    {
        // Arrange
        /** @var CityApiClientInterface $cityApi */
        $cityApi = $this->initializeCityApiClient();
        /** @var DenormalizerInterface $denormalizer */
        $denormalizer = $this->initializeCityDenormalizer();
        $sut = $this->initializeCityProvider($cityApi, $denormalizer);
        $cities = $this->provideCitiesData(3);

        /** @var MockInterface $cityApi */
        /** @var Expectation $expectation */
        $expectation = $cityApi->shouldReceive('fetchCities');
        $expectation->andReturn($cities);

        /** @var MockInterface $denormalizer */
        /** @var Expectation $expectation */
        $expectation = $denormalizer->shouldReceive('denormalize');
        $expectation->andReturnUsing(function (array $cityData) {
            return $this->provideCity($cityData);
        });

        // Act
        $result = $sut->getCities();

        // Assert
        $this->assertContainsOnlyInstancesOf(City::class, $result);
        $this->assertEquals($cities[0]['id'], $result[0]->getId());
        $this->assertEquals($cities[1]['id'], $result[1]->getId());
        $this->assertEquals($cities[2]['id'], $result[2]->getId());
    }

    private function initializeCityApiClient(): MockInterface
    {
        return $this->spy(CityApiClientInterface::class);
    }

    private function initializeCityDenormalizer(): MockInterface
    {
        return $this->spy(DenormalizerInterface::class);
    }

    private function initializeCityProvider(
        CityApiClientInterface $cityApi,
        DenormalizerInterface $denormalizer
    ): CityProvider {
        return new CityProvider($cityApi, $denormalizer);
    }
}
