<?php

namespace Http\Psr7Test\Tests\Nyholm;

use Http\Psr7Test\RequestIntegrationTest;
use Nyholm\Psr7\Request;

class RequestTest extends RequestIntegrationTest
{
    public function createSubject()
    {
        return new Request('GET', '/');
    }
}
