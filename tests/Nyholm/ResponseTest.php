<?php

namespace Http\Psr7Test\Tests\Nyholm;

use Http\Psr7Test\ResponseIntegrationTest;
use Nyholm\Psr7\Response;

class ResponseTest extends ResponseIntegrationTest
{
    public function createSubject()
    {
        return new Response();
    }
}
