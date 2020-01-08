<?php

namespace Http\Psr7Test\Tests\Laminas;

use Http\Psr7Test\ResponseIntegrationTest;
use Laminas\Diactoros\Response;

class ResponseTest extends ResponseIntegrationTest
{
    public function createSubject()
    {
        return new Response();
    }
}
