<?php

namespace Http\Psr7Test\Tests\Laminas;

use Http\Psr7Test\ServerRequestIntegrationTest;
use Laminas\Diactoros\ServerRequest;

class ServerRequestTest extends ServerRequestIntegrationTest
{
    public function createSubject()
    {
        return new ServerRequest($_SERVER);
    }
}
