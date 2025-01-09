<?php

declare(strict_types=1);

namespace App\Services\CommissionCalculationService\Provider\BinListProvider\Model;

/**
 * numeric:"440"
 * alpha2:"LT"
 * name:"Lithuania"
 * emoji:"🇱🇹"
 * currency:"EUR"
 * latitude:56
 * longitude:24
 */
class BinCountry
{
    private string $name;
    private string $alpha2;
    private string $emoji;
    private string $currency;
    private float $latitude;
    private float $longitude;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAlpha2(): string
    {
        return $this->alpha2;
    }

    public function setAlpha2(string $alpha2): void
    {
        $this->alpha2 = $alpha2;
    }

    public function getEmoji(): string
    {
        return $this->emoji;
    }

    public function setEmoji(string $emoji): void
    {
        $this->emoji = $emoji;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }
}
