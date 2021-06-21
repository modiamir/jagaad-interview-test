<?php

namespace Tests\Unit\Normalizer;

use App\Normalizer\Denormalizer;
use App\Normalizer\ModelDenormalizerInterface;
use Mockery\Expectation;
use Mockery\MockInterface;
use Tests\TestCase;

class ObjectNormalizerTest extends TestCase
{
    /**
     * @test
     */
    public function it_finds_proper_model_denormalizer_and_denormalizes_model(): void
    {
        // Arrange
        $data = [
            'key_one' => $this->faker()->word,
            'key_two' => $this->faker()->randomNumber(),
        ];
        $denormalizedData = new SampleModelClass();
        $denormalizedData->keyOne = $data['key_one'];
        $denormalizedData->setKeyTwo($data['key_two']);

        /** @var ModelDenormalizerInterface $sampleModelDenormalizer */
        $sampleModelDenormalizer = $this->initializeModelDenormalizer();
        /** @var ModelDenormalizerInterface $anotherModelDenormalizer */
        $anotherModelDenormalizer = $this->initializeModelDenormalizer();
        $sut = $this->initializeDenormalizer([$anotherModelDenormalizer, $sampleModelDenormalizer]);

        /** @var MockInterface $sampleModelDenormalizer */
        /** @var Expectation $expectation */
        $expectation = $sampleModelDenormalizer->shouldReceive('supportsModel');
        $expectation
            ->with($data, SampleModelClass::class)
            ->andReturn(true)
        ;

        /** @var Expectation $expectation */
        $expectation = $sampleModelDenormalizer->shouldReceive('denormalize');
        $expectation
            ->with($data, SampleModelClass::class)
            ->andReturn($denormalizedData)
        ;

        /** @var MockInterface $anotherModelDenormalizer */
        /** @var Expectation $expectation */
        $expectation = $anotherModelDenormalizer->shouldReceive('supportsModel');
        $expectation
            ->with($data, SampleModelClass::class)
            ->andReturn(false)
        ;

        // Act
        $result = $sut->denormalize($data, SampleModelClass::class);

        // Assert
        $this->assertEquals($denormalizedData, $result);
        $anotherModelDenormalizer
            ->shouldHaveReceived('supportsModel')
            ->with($data, SampleModelClass::class)
            ->once();
        $sampleModelDenormalizer
            ->shouldHaveReceived('supportsModel')
            ->with($data, SampleModelClass::class)
            ->once();
        $sampleModelDenormalizer
            ->shouldHaveReceived('denormalize')
            ->with($data, SampleModelClass::class)
            ->once();
    }

    private function initializeModelDenormalizer(): MockInterface
    {
        return $this->spy(ModelDenormalizerInterface::class);
    }

    /**
     * @param array<ModelDenormalizerInterface> $denormalizers
     *
     * @return Denormalizer
     */
    private function initializeDenormalizer(array $denormalizers): Denormalizer
    {
        return new Denormalizer($denormalizers);
    }
}

class SampleModelClass
{
    public ?string $keyOne = null;

    private ?int $keyTwo = null;

    public function getKeyTwo(): ?int
    {
        return $this->keyTwo;
    }

    public function setKeyTwo(?int $keyTwo): void
    {
        $this->keyTwo = $keyTwo;
    }
}
