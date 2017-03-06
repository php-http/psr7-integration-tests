<?php

namespace Http\Psr7Test\Tests\Guzzle;

use GuzzleHttp\Psr7\ServerRequest;
use Http\Psr7Test\ServerRequestIntegrationTest;

class ServerRequestTest extends ServerRequestIntegrationTest
{
    public function createSubject()
    {
        return new ServerRequest('GET', '/', [], null, '1.1', $_SERVER);
    }
}
