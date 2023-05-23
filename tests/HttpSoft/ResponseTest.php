<?php

declare(strict_types=1);

namespace Http\Psr7Test\Tests\HttpSoft;

use Http\Psr7Test\ResponseIntegrationTest;
use HttpSoft\Message\Response;

class ResponseTest extends ResponseIntegrationTest
{
    public function createSubject()
    {
        return new Response();
    }
}
