<?php

namespace Http\Psr7Test\Tests\HttpSoft;

use Http\Psr7Test\ServerRequestIntegrationTest;
use HttpSoft\Message\ServerRequest;

class ServerRequestTest extends ServerRequestIntegrationTest
{
    public function createSubject()
    {
        return new ServerRequest($_SERVER);
    }
}
