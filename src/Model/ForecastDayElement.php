<?php

namespace App\Model;

class ForecastDayElement
{
    /**
     * @var ForecastCondition
     */
    private ForecastCondition $condition;

    public function __construct()
    {
        $this->condition = new ForecastCondition();
    }

    /**
     * @return ForecastCondition
     */
    public function getCondition(): ForecastCondition
    {
        return $this->condition;
    }

    /**
     * @param ForecastCondition $condition
     *
     * @return $this
     */
    public function setCondition(ForecastCondition $condition): self
    {
        $this->condition = $condition;

        return $this;
    }
}
