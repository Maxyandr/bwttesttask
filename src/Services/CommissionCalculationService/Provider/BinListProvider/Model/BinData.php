<?php

declare(strict_types=1);

namespace App\Services\CommissionCalculationService\Provider\BinListProvider\Model;

/**
 * scheme:"mastercard"
 * type:"debit"
 * brand:"Debit Mastercard"
 */
class BinData
{
    private string $scheme;
    private string $type;
    private string $brand;
    private BinCountry $country;
    private BinBank $bank;

    public function getBank(): BinBank
    {
        return $this->bank;
    }

    public function setBank(BinBank $bank): void
    {
        $this->bank = $bank;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function setScheme(string $scheme): void
    {
        $this->scheme = $scheme;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getCountry(): BinCountry
    {
        return $this->country;
    }

    public function setCountry(BinCountry $country): void
    {
        $this->country = $country;
    }
}
