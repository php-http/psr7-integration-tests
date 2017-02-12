<?php

namespace Http\Psr7Test\Tests\Slim;

use Http\Psr7Test\RequestIntegrationTest;
use Slim\Http\Body;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Uri;

class RequestTest extends RequestIntegrationTest
{
    public function createSubject()
    {
        return new Request('GET', new Uri('http', 'foo.com'), new Headers([]), [], [], new Body(fopen('php://temp', 'r+')));
    }
}
