<?php

namespace App\Normalizer;

use App\Model\Forecast;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as SymfonyDenormalizerInterface;

class ForecastDenormalizer implements ModelDenormalizerInterface
{
    private SymfonyDenormalizerInterface $denormalizer;

    public function __construct(SymfonyDenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }

    public function denormalize(array $data, string $type): object
    {
        return $this->denormalizer->denormalize($data, $type, 'json');
    }

    public function supportsModel(array $data, string $type): bool
    {
        return $type === Forecast::class && $this->denormalizer->supportsDenormalization($data, $type);
    }
}
