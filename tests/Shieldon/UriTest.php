<?php

namespace Http\Psr7Test\Tests\Shieldon;

use Http\Psr7Test\UriIntegrationTest;
use Shieldon\Psr7\Uri;

class UriTest extends UriIntegrationTest
{
    public function createUri($uri)
    {
        return new Uri($uri);
    }
}
