<?php

namespace Http\Psr7Test\Tests\Zend;

use Http\Psr7Test\UriIntegrationTest;
use Zend\Diactoros\Uri;

class UriTest extends UriIntegrationTest
{
    public function createUri($uri)
    {
        return new Uri($uri);
    }
}
