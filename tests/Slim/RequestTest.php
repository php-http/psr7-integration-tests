<?php

namespace Http\Psr7Test\Tests\Slim;

use Http\Psr7Test\RequestIntegrationTest;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Factory\UriFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;

class RequestTest extends RequestIntegrationTest
{
    public function createSubject()
    {
        return new Request(
            'GET',
            (new UriFactory())->createUri('/'),
            new Headers([]),
            [],
            [],
            (new StreamFactory())->createStream()
        );
    }
}
