<?php

namespace App\Normalizer;

interface ModelDenormalizerInterface extends DenormalizerInterface
{
    /**
     * @param array<string,mixed> $data
     * @param string $type
     *
     * @return bool
     */
    public function supportsModel(array $data, string $type): bool;
}
