<?php

namespace Tests\Unit\Normalizer;

use App\Model\Forecast;
use App\Normalizer\ForecastDenormalizer;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tests\DataFactory;
use Tests\TestCase;

class ForecastDenormalizerTest extends TestCase
{
    use DataFactory;

    /**
     * @test
     * @dataProvider provideDataForSupportMethodTest
     */
    public function it_supports_forecast_model(string $modelType, bool $expectedResult): void
    {
        // Arrange
        $data = $this->provideForecastData();

        $symfonyDenormalizer = $this->initializeSymfonyNormalizer();
        $sut = $this->initializeForecastDenormalizer($symfonyDenormalizer);

        // Act
        $result = $sut->supportsModel($data, $modelType);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function it_denormalizes_data_to_forecast_model(): void
    {
        // Arrange
        $data = $this->provideForecastData();

        $symfonyDenormalizer = $this->initializeSymfonyNormalizer();
        $sut = $this->initializeForecastDenormalizer($symfonyDenormalizer);

        // Act
        /** @var Forecast $result */
        $result = $sut->denormalize($data, Forecast::class);

        // Assert
        $this->assertInstanceOf(Forecast::class, $result);
        $this->assertEquals($data, [
            "forecastday" => [
                [
                    "date" => $result->getForecastday()[0]->getDate(),
                    "date_epoch" => $result->getForecastday()[0]->getDateEpoch(),
                    "day" => [
                        "condition" => [
                            "text" => $result->getForecastday()[0]->getDay()->getCondition()->getText(),
                            "icon" => $result->getForecastday()[0]->getDay()->getCondition()->getIcon(),
                            "code" => $result->getForecastday()[0]->getDay()->getCondition()->getCode(),
                        ]
                    ]
                ],
                [
                    "date" => $result->getForecastday()[1]->getDate(),
                    "date_epoch" => $result->getForecastday()[1]->getDateEpoch(),
                    "day" => [
                        "condition" => [
                            "text" => $result->getForecastday()[1]->getDay()->getCondition()->getText(),
                            "icon" => $result->getForecastday()[1]->getDay()->getCondition()->getIcon(),
                            "code" => $result->getForecastday()[1]->getDay()->getCondition()->getCode(),
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @return array<string,array<int,bool|string>>
     */
    public function provideDataForSupportMethodTest(): array
    {
        $faker = $this->makeFaker();

        return [
            'Forecast model' => [
                Forecast::class, // Model type
                true, // Result
            ],
            'Non-Forecast model' => [
                $faker->word, // Model type
                false, // Result
            ],
        ];
    }

    private function initializeSymfonyNormalizer(): Serializer
    {
        $normalizer = new ObjectNormalizer(
            null,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            new PhpDocExtractor()
        );

        return new Serializer([$normalizer, new ArrayDenormalizer()]);
    }

    private function initializeForecastDenormalizer(DenormalizerInterface $denormalizer): ForecastDenormalizer
    {
        return new ForecastDenormalizer($denormalizer);
    }
}
