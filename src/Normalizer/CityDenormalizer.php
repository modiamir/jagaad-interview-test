<?php

namespace App\Normalizer;

use App\Model\City;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CityDenormalizer implements ModelDenormalizerInterface
{
    private DenormalizerInterface $denormalizer;

    public function __construct(DenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }

    public function denormalize(array $data, string $type): object
    {
        return $this->denormalizer->denormalize($data, $type);
    }

    public function supportsModel(array $data, string $type): bool
    {
        return $type === City::class && $this->denormalizer->supportsDenormalization($data, $type);
    }
}
