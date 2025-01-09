<?php

declare(strict_types=1);

namespace App\Services\CommissionCalculationService\Provider\BinListProvider;

use App\Client\ApiClientInterface;
use App\Client\Request\Factory\BinListRequestFactory;
use App\Services\CommissionCalculationService\Provider\BinListProvider\Model\BinData;
use Symfony\Component\Serializer\SerializerInterface;

class BinListProvider implements BinListProviderInterface
{
    public function __construct(
        private ApiClientInterface $apiClient,
        private SerializerInterface $serializer,
        private BinListRequestFactory $binListRequestFactory,
    ) {

    }

    public function getBinData(string $bin): BinData
    {
        $response = $this->apiClient->request($this->binListRequestFactory->create($bin));
        $content = $response->getBody()->getContents();

        if (!$content) {
            throw new \RuntimeException("Failed to fetch BIN data for: $bin");
        }

        try {
            return $this->serializer->deserialize($content, BinData::class, 'json');
        } catch (\Exception $e) {
            throw new \RuntimeException("Invalid response for BIN: $bin", 0, $e);
        }
    }
}
