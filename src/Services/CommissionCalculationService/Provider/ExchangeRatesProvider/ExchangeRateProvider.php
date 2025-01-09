<?php

declare(strict_types=1);

namespace App\Services\CommissionCalculationService\Provider\ExchangeRatesProvider;

use App\Client\ApiClientInterface;
use App\Client\Request\Factory\ExchangeRatesRequestFactory;
use App\Services\CommissionCalculationService\Provider\ExchangeRatesProvider\Model\ExchangeRate;
use Symfony\Component\Serializer\SerializerInterface;

class ExchangeRateProvider implements ExchangeRateProviderInterface
{
    public function __construct(
        private ApiClientInterface          $apiClient,
        private SerializerInterface         $serializer,
        private ExchangeRatesRequestFactory $exchangeRatesApiFactory,
    ) {
    }

    public function getRate(string $currency): float
    {
        $response = $this->apiClient->request($this->exchangeRatesApiFactory->create());
        $content = $response->getBody()->getContents();

        if (!$content) {
            throw new \RuntimeException("Failed to fetch exchange rate data.");
        }

        try {
            $rateData = $this->serializer->deserialize($content, ExchangeRate::class, 'json');
        } catch (\Exception $e) {
            throw new \RuntimeException("Invalid response for exchange rate data.", 0, $e);
        }

        if (!$rateData->getRates()[$currency]) {
            throw new \RuntimeException("Invalid response for exchange rate data.");
        }

        return $rateData->getRates()[$currency];
    }
}
