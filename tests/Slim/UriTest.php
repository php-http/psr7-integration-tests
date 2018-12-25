<?php

namespace Http\Psr7Test\Tests\Slim;

use Http\Psr7Test\UriIntegrationTest;
use Slim\Psr7\Factory\UriFactory;

class UriTest extends UriIntegrationTest
{
    public function createUri($uri)
    {
        return (new UriFactory())->createUri($uri);
    }
}
