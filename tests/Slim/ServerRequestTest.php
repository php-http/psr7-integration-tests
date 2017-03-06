<?php

namespace Http\Psr7Test\Tests\Slim;

use Slim\Http\Body;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Uri;
use Http\Psr7Test\ServerRequestIntegrationTest;

class ServerRequestTest extends ServerRequestIntegrationTest
{
    public function createSubject()
    {
        return new Request('GET', new Uri('http', 'foo.com'), new Headers([]), $_COOKIE, $_SERVER, new Body(fopen('php://temp', 'r+')));
    }
}
