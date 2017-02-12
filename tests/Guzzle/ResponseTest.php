<?php

namespace Http\Psr7Test\Tests\Guzzle;

use GuzzleHttp\Psr7\Response;
use Http\Psr7Test\ResponseIntegrationTest;

class ResponseTest extends ResponseIntegrationTest
{
    public function createSubject()
    {
        return new Response();
    }
}
