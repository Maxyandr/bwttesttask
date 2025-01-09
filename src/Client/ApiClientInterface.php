<?php

declare(strict_types=1);

namespace App\Client;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ApiClientInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function request(ServerRequestInterface $request): ResponseInterface;
}
