<?php

declare(strict_types=1);

namespace Http\Psr7Test\Tests\HttpSoft;

use Http\Psr7Test\RequestIntegrationTest;
use HttpSoft\Message\Request;
use HttpSoft\Message\Uri;

class RequestTest extends RequestIntegrationTest
{
    public function createSubject()
    {
        return new Request('GET', '/');
    }

    protected function buildUri($uri)
    {
        return new Uri($uri);
    }
}
