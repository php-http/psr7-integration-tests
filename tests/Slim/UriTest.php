<?php

namespace Http\Psr7Test\Tests\Slim;

use Http\Psr7Test\UriIntegrationTest;
use Slim\Http\Uri;

class UriTest extends UriIntegrationTest
{
    public function createUri($uri)
    {
        return Uri::createFromString($uri);
    }
}
