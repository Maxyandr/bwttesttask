<?php

namespace App\Services\CommissionCalculationService\Provider\ExchangeRatesProvider;

interface ExchangeRateProviderInterface
{
    public function getRate(string $currency): float;
}
