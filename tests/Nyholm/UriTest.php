<?php

namespace Http\Psr7Test\Tests\Nyholm;

use Http\Psr7Test\UriIntegrationTest;
use Nyholm\Psr7\Uri;

class UriTest extends UriIntegrationTest
{
    public function createUri($uri)
    {
        return new Uri($uri);
    }
}
