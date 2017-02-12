<?php

namespace Http\Psr7Test\Tests\Zend;

use Http\Psr7Test\ServerRequestIntegrationTest;
use Zend\Diactoros\ServerRequest;

class ServerRequestTest extends ServerRequestIntegrationTest
{
    public function createSubject()
    {
        return new ServerRequest();
    }
}
