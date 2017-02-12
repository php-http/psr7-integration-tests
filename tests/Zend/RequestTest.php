<?php

namespace Http\Psr7Test\Tests\Zend;

use Http\Psr7Test\RequestIntegrationTest;
use Zend\Diactoros\Request;

class RequestTest extends RequestIntegrationTest
{
    public function createSubject()
    {
        return new Request('/', 'GET');
    }
}
