<?php

namespace App\Normalizer;

interface DenormalizerInterface
{
    /**
     * @param array<string,mixed> $data
     * @param string $type
     *
     * @return object
     */
    public function denormalize(array $data, string $type): object;
}
