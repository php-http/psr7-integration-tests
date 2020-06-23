<?php

namespace Http\Psr7Test\Tests\Shieldon;

use Http\Psr7Test\RequestIntegrationTest;
use Shieldon\Psr7\Request;

class RequestTest extends RequestIntegrationTest
{
    public function createSubject()
    {
        return new Request('GET', '/');
    }
}
