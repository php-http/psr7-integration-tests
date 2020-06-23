<?php

namespace Http\Psr7Test\Tests\Shieldon;

use Http\Psr7Test\ResponseIntegrationTest;
use Shieldon\Psr7\Response;

class ResponseTest extends ResponseIntegrationTest
{
    public function createSubject()
    {
        return new Response();
    }
}
