<?php

namespace Http\Psr7Test\Tests\RingCentral;

use RingCentral\Psr7\Uri;
use Http\Psr7Test\UriIntegrationTest;

class UriTest extends UriIntegrationTest
{
    public function createUri($uri)
    {
        return new Uri($uri);
    }
}
