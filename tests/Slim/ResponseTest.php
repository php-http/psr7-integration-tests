<?php

namespace Http\Psr7Test\Tests\Slim;

use Http\Psr7Test\ResponseIntegrationTest;
use Slim\Psr7\Response;

class ResponseTest extends ResponseIntegrationTest
{
    public function createSubject()
    {
        return new Response();
    }
}
