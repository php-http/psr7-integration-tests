<?php

namespace Http\Psr7Test\Tests\Shieldon;

use Http\Psr7Test\StreamIntegrationTest;
use Psr\Http\Message\StreamInterface;
use Shieldon\Psr7\Stream;

class StreamTest extends StreamIntegrationTest
{
    public function createStream($data)
    {
        if ($data instanceof StreamInterface) {
            return $data;
        }

        return new Stream($data);
    }
}
