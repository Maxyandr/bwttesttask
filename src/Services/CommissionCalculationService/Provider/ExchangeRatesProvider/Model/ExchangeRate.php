<?php

declare(strict_types=1);

namespace App\Services\CommissionCalculationService\Provider\ExchangeRatesProvider\Model;

/**
 * {
 * "base": "EUR",
 * "date": "2025-01-09",
 * "rates": {
 *    "AED": 3.781643,
 * },
 * "success": true,
 * "timestamp": 1736443683
 * }
 */
class ExchangeRate
{
    private string $base;
    private string $date;
    private array $rates;
    private bool $success;
    private int $timestamp;

    public function getBase(): string
    {
        return $this->base;
    }

    public function setBase(string $base): void
    {
        $this->base = $base;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getRates(): array
    {
        return $this->rates;
    }

    public function setRates(array $rates): void
    {
        $this->rates = $rates;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}
