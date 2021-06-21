<?php

namespace App\Model;

class Forecast
{
    /**
     * @var array<ForecastDay>
     */
    private array $forecastday = [];

    /**
     * @return array<ForecastDay>
     */
    public function getForecastday(): array
    {
        return $this->forecastday;
    }

    /**
     * @param array<ForecastDay> $forecastday
     *
     * @return $this
     */
    public function setForecastday(array $forecastday): self
    {
        $this->forecastday = $forecastday;

        return $this;
    }
}
