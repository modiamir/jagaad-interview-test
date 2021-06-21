<?php

namespace App\Model;

class ForecastDay
{
    private ?string $date = null;

    private ?int $dateEpoch = null;

    /**
     * @var ForecastDayElement
     */
    private ForecastDayElement $day;

    public function __construct()
    {
        $this->day = new ForecastDayElement();
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDateEpoch(): ?int
    {
        return $this->dateEpoch;
    }

    public function setDateEpoch(?int $dateEpoch): self
    {
        $this->dateEpoch = $dateEpoch;

        return $this;
    }

    /**
     * @return ForecastDayElement
     */
    public function getDay(): ForecastDayElement
    {
        return $this->day;
    }

    /**
     * @param ForecastDayElement $day
     *
     * @return $this
     */
    public function setDay(ForecastDayElement $day): self
    {
        $this->day = $day;

        return $this;
    }
}
