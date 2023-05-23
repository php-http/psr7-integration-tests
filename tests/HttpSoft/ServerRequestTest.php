<?php

namespace Http\Psr7Test\Tests\HttpSoft;

use Http\Psr7Test\ServerRequestIntegrationTest;
use HttpSoft\Message\ServerRequest;
use HttpSoft\Message\Uri;

class ServerRequestTest extends ServerRequestIntegrationTest
{
    public function createSubject()
    {
        return new ServerRequest($_SERVER);
    }

    protected function buildUri($uri)
    {
        return new Uri($uri);
    }
}
