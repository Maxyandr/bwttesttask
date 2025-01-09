<?php

declare(strict_types=1);

namespace App\Services\CommissionCalculationService;

use App\Entity\Transaction;
use App\Services\CommissionCalculationService\Provider\BinListProvider\BinListProviderInterface;
use App\Services\CommissionCalculationService\Provider\BinListProvider\BinListProvider;
use App\Services\CommissionCalculationService\Provider\ExchangeRatesProvider\ExchangeRateProviderInterface;
use App\Services\CommissionCalculationService\Provider\ExchangeRatesProvider\ExchangeRateProvider;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CommissionCalculationService
{
    private const EU_COUNTRY_CODES = [
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR',
            'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO',
            'SE', 'SI', 'SK'
        ];

    private const DEFAULT_COMMISSION_RATE = 0.02;
    private const DEFAULT_COMMISSION_EU_RATE = 0.01;

    public function __construct(
        #[Autowire(service: BinListProvider::class)]
        private BinListProviderInterface $binService,

        #[Autowire(service: ExchangeRateProvider::class)]
        private ExchangeRateProviderInterface $exchangeRateService,
    ) {

    }

    public function calculateCommission(Transaction $transaction): string
    {
        $binData = $this->binService->getBinData($transaction->getBin());

        $amount = $transaction->getAmount();
        $currency = $transaction->getCurrency();
        $exchangeRate = $this->exchangeRateService->getRate($transaction->getCurrency());

        // Calculate amount in EUR
        if ($currency === 'EUR' || $exchangeRate == 0) {
            $amountInEur = $amount;
        } else {

            $amountInEur = $amount / $exchangeRate;
        }

        $commissionRate = $this->getCommissionRate($binData->getCountry()->getAlpha2());
        $commission = ceil($amountInEur * $commissionRate * 100) / 100;

        return number_format($commission, 2, '.', '');
    }

    private function getCommissionRate(string $countryCode): float
    {
        $isEU = in_array($countryCode, self::EU_COUNTRY_CODES);
        return $isEU ? self::DEFAULT_COMMISSION_EU_RATE : self::DEFAULT_COMMISSION_RATE;
    }
}
