<?php

declare(strict_types=1);

namespace App\Tests\Services\CommissionCalculationService;

use App\Entity\Transaction;
use App\Services\CommissionCalculationService\CommissionCalculationService;
use App\Services\CommissionCalculationService\Provider\BinListProvider\BinListProviderInterface;
use App\Services\CommissionCalculationService\Provider\BinListProvider\Model\BinCountry;
use App\Services\CommissionCalculationService\Provider\BinListProvider\Model\BinData;
use App\Services\CommissionCalculationService\Provider\ExchangeRatesProvider\ExchangeRateProviderInterface;
use PHPUnit\Framework\TestCase;

class CommissionCalculationServiceTest extends TestCase
{
    private BinListProviderInterface $binServiceMock;
    private ExchangeRateProviderInterface $exchangeRateMock;
    private CommissionCalculationService $commissionCalculationService;

    protected function setUp(): void
    {
        $this->binServiceMock = $this->createMock(BinListProviderInterface::class);
        $this->exchangeRateMock = $this->createMock(ExchangeRateProviderInterface::class);
        $this->commissionCalculationService = new CommissionCalculationService(
            $this->binServiceMock,
            $this->exchangeRateMock
        );
    }

    public function testCalculateCommissionForEUCurrency(): void
    {
        $transaction = $this->createTransaction('45717360', '100.0', 'EUR');

        $binCountry = $this->createBinCountry('FR');
        $binData = $this->createBinData($binCountry);

        $this->binServiceMock
            ->method('getBinData')
            ->with('45717360')
            ->willReturn($binData);

        $this->exchangeRateMock
            ->expects($this->once())
            ->method('getRate');

        $result = $this->commissionCalculationService->calculateCommission($transaction);

        $this->assertEquals('1.00', $result);
    }

    public function testCalculateCommissionForNonEUCurrency(): void
    {
        $transaction = $this->createTransaction('45321900', '500.0', 'USD');

        $binCountry = $this->createBinCountry('US');
        $binData = $this->createBinData($binCountry);

        $this->binServiceMock
            ->method('getBinData')
            ->with('45321900')
            ->willReturn($binData);

        $this->exchangeRateMock
            ->method('getRate')
            ->with('USD')
            ->willReturn(1.2);

        $result = $this->commissionCalculationService->calculateCommission($transaction);

        $this->assertEquals('8.34', $result);
    }

    public function testCalculateCommissionForNonEUBinEUTransaction(): void
    {
        $transaction = $this->createTransaction('53812172', '300.0', 'EUR');

        $binCountry = $this->createBinCountry('US');
        $binData = $this->createBinData($binCountry);

        $this->binServiceMock
            ->method('getBinData')
            ->with('53812172')
            ->willReturn($binData);

        $this->exchangeRateMock
            ->expects($this->once())
            ->method('getRate');

        $result = $this->commissionCalculationService->calculateCommission($transaction);

        $this->assertEquals('6.00', $result);
    }

    public function testCalculateCommissionForZeroExchangeRate(): void
    {
        $transaction = $this->createTransaction('45002196', '200.0', 'GBP');

        $binCountry = $this->createBinCountry('GB');
        $binData = $this->createBinData($binCountry);

        $this->binServiceMock
            ->method('getBinData')
            ->with('45002196')
            ->willReturn($binData);

        $this->exchangeRateMock
            ->method('getRate')
            ->with('GBP')
            ->willReturn(0.0);

        $result = $this->commissionCalculationService->calculateCommission($transaction);

        $this->assertEquals('4.00', $result);
    }

    private function createTransaction(string $bin, string $amount, string $currency): Transaction
    {
        $transaction = new Transaction();
        $transaction->setBin($bin);
        $transaction->setAmount($amount);
        $transaction->setCurrency($currency);
        return $transaction;
    }

    private function createBinCountry(string $alpha2): BinCountry
    {
        $country = $this->createMock(BinCountry::class);
        $country->method('getAlpha2')->willReturn($alpha2);
        return $country;
    }

    private function createBinData(BinCountry $country): BinData
    {
        $binData = $this->createMock(BinData::class);
        $binData->method('getCountry')->willReturn($country);
        return $binData;
    }
}
