<?php

namespace Tests\Unit\Normalizer;

use App\Model\City;
use App\Normalizer\CityDenormalizer;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tests\DataFactory;
use Tests\TestCase;

class CityDenormalizerTest extends TestCase
{
    use DataFactory;

    /**
     * @test
     * @dataProvider provideDataForSupportMethodTest
     */
    public function it_supports_city_model(string $modelType, bool $expectedResult): void
    {
        // Arrange
        $data = $this->provideCityData();

        $symfonyDenormalizer = $this->initializeSymfonyDenormalizer();
        $sut = $this->initializeCityDenormalizer($symfonyDenormalizer);

        // Act
        $result = $sut->supportsModel($data, $modelType);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function it_denormalizes_data_to_city_model(): void
    {
        // Arrange
        $data = $this->provideCityData();

        $symfonyDenormalizer = $this->initializeSymfonyDenormalizer();
        $sut = $this->initializeCityDenormalizer($symfonyDenormalizer);

        // Act
        /** @var City $result */
        $result = $sut->denormalize($data, City::class);

        // Assert
        $this->assertInstanceOf(City::class, $result);
        $this->assertEquals($data, [
            'id' => $result->getId(),
            'name' => $result->getName(),
            'latitude' => $result->getLatitude(),
            'longitude' => $result->getLongitude(),
        ]);
    }

    /**
     * @return array<string,array<int,bool|string>>
     */
    public function provideDataForSupportMethodTest(): array
    {
        $faker = $this->makeFaker();

        return [
            'City model' => [
                City::class, // Model type
                true, // Result
            ],
            'Non-City model' => [
                $faker->word, // Model type
                false, // Result
            ],
        ];
    }

    private function initializeSymfonyDenormalizer(): Serializer
    {
        $normalizer = new ObjectNormalizer(
            null,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            new PhpDocExtractor()
        );

        return new Serializer([$normalizer, new ArrayDenormalizer()]);
    }

    private function initializeCityDenormalizer(DenormalizerInterface $denormalizer): CityDenormalizer
    {
        return new CityDenormalizer($denormalizer);
    }
}
