<?php

namespace Http\Psr7Test\Tests\Zend;

use Http\Psr7Test\ResponseIntegrationTest;
use Zend\Diactoros\Response;

class ResponseTest extends ResponseIntegrationTest
{
    public function createSubject()
    {
        return new Response();
    }
}
