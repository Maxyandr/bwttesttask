<?php

declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GuzzleApiClient implements ApiClientInterface
{
    public function __construct(private ClientInterface $client)
    {
    }

    public function request(ServerRequestInterface $request): ResponseInterface
    {
        return $this->client->send($request);
    }
}
