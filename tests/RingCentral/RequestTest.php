<?php

namespace Http\Psr7Test\Tests\RingCentral;

use RingCentral\Psr7\Request;
use Http\Psr7Test\RequestIntegrationTest;

class RequestTest extends RequestIntegrationTest
{
    public function createSubject()
    {
        return new Request('GET', '/');
    }
}
