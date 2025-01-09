<?php

namespace App\Client\Request\Factory;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class BinListRequestFactory
{
    private const BASE_URL = 'https://lookup.binlist.net';

    public function create(string $bin): ServerRequestInterface
    {
        return new ServerRequest(
            'GET',
            sprintf('%s/%s', self::BASE_URL, $bin)
        );
    }
}
