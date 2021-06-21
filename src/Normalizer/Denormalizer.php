<?php

namespace App\Normalizer;

use InvalidArgumentException;

class Denormalizer implements DenormalizerInterface
{
    /**
     * @var iterable|ModelDenormalizerInterface[]
     */
    private iterable $denormalizers;

    /**
     * @param iterable|ModelDenormalizerInterface[] $denormalizers
     */
    public function __construct(iterable $denormalizers)
    {
        $this->denormalizers = $denormalizers;
    }

    /**
     * @param array<string,mixed> $data
     * @param string $type
     *
     * @return object
     */
    public function denormalize(array $data, string $type): object
    {
        foreach ($this->denormalizers as $denormalizer) {
            if (!$denormalizer->supportsModel($data, $type)) {
                continue;
            }

            return $denormalizer->denormalize($data, $type);
        }

        throw new InvalidArgumentException('There is no supportive denormalizer for given type');
    }
}
