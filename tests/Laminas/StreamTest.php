<?php

namespace Http\Psr7Test\Tests\Laminas;

use Http\Psr7Test\StreamIntegrationTest;
use Laminas\Diactoros\Stream;
use Psr\Http\Message\StreamInterface;

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
