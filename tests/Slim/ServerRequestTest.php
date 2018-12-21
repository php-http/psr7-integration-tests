<?php

namespace Http\Psr7Test\Tests\Slim;

use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Factory\UriFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;
use Http\Psr7Test\ServerRequestIntegrationTest;

class ServerRequestTest extends ServerRequestIntegrationTest
{
    public function createSubject()
    {
        return new Request(
            'GET',
            (new UriFactory())->createUri('/'),
            new Headers([]),
            $_COOKIE,
            $_SERVER,
            (new StreamFactory())->createStream()
        );
    }
}
