<?php

namespace Http\Psr7Test\Tests\Nyholm;

use Http\Psr7Test\StreamIntegrationTest;
use Nyholm\Psr7\Stream;

class StreamTest extends StreamIntegrationTest
{
    public function createStream($data)
    {
        return Stream::create($data);
    }
}
