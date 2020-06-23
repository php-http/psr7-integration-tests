<?php

namespace Http\Psr7Test\Tests\Shieldon;

use Http\Psr7Test\ServerRequestIntegrationTest;
use Shieldon\Psr17\ServerRequestFactory;

class ServerRequestTest extends ServerRequestIntegrationTest
{
    public function createSubject()
    {
        return ServerRequestFactory::fromGlobal();
    }
}
