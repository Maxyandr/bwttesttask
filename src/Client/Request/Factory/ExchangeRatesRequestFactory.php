<?php

namespace App\Client\Request\Factory;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class ExchangeRatesRequestFactory
{
    public function __construct(
        private string $apiKey,
        private ?string $apiHost
    ) {
    }

    public function create(): ServerRequestInterface
    {
        return new ServerRequest(
            'GET',
            sprintf('%s/latest', $this->apiHost),
            headers: ['apikey' => $this->apiKey]
        );
    }
}
