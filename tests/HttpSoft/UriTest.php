<?php

namespace Http\Psr7Test\Tests\HttpSoft;

use Http\Psr7Test\UriIntegrationTest;
use HttpSoft\Message\Uri;

class UriTest extends UriIntegrationTest
{
    public function createUri($uri)
    {
        return new Uri($uri);
    }
}
