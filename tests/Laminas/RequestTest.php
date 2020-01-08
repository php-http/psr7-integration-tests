<?php

namespace Http\Psr7Test\Tests\Laminas;

use Http\Psr7Test\RequestIntegrationTest;
use Laminas\Diactoros\Request;

class RequestTest extends RequestIntegrationTest
{
    public function createSubject()
    {
        return new Request('/', 'GET');
    }
}
