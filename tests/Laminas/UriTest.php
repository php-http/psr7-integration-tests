<?php

namespace Http\Psr7Test\Tests\Laminas;

use Http\Psr7Test\UriIntegrationTest;
use Laminas\Diactoros\Uri;

class UriTest extends UriIntegrationTest
{
    public function createUri($uri)
    {
        return new Uri($uri);
    }
}
